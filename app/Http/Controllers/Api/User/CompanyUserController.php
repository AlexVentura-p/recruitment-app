<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexCompanyUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\Auth\CompanyAuth;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;

class CompanyUserController extends Controller
{
    private CompanyAuth $changeValidator;

    public function __construct(CompanyAuth $companyAuth)
    {
        $this->changeValidator = $companyAuth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCompanyUserRequest $request)
    {
        $attributes = $request->validated();

        $role = Role::where('name','=',$attributes['role'])->first();
        $company = Company::find($attributes['company_id']);

        if(!$this->scopeChecker($attributes['role'],$company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response(
            User::where('role_id','=',$role->id)
                ->where('company_id','=',$company->id)->get()
        );

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->role->name == 'admin'){
            return response(['message' => 'Forbidden'], 403);
        }

        if(!$this->scopeChecker($user->role->name,$user->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $attributes = $request->validated();

        if ($user->role->name == 'admin'){
            return response(['message' => 'Forbidden'], 403);
        }

        if(!$this->scopeChecker($user->role->name,$user->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $user->update($attributes);

        return response($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->role->name == 'admin'){
            return response(['message' => 'Forbidden'], 403);
        }

        if(!$this->scopeChecker($user->role->name,$user->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $user->delete();
        return response('No content', 204);

    }

    private function scopeChecker(string $role, Company $company): bool
    {
        $user = auth()->user();

        if($this->changeValidator->validate($company)){
            if ($role == 'admin-company' && $user->tokenCan('crud_admin_company')) {
                return true;
            }

            if ($role == 'recruiter' && $user->tokenCan('crud_recruiters')) {
                return true;
            }
        }

        return false;
    }

}
