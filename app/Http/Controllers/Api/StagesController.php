<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stages\StageStoreRequest;
use App\Http\Requests\Stages\StageUpdateRequest;
use App\Http\Services\Auth\BasicCompanyAuthorization;
use App\Http\Services\Auth\CompanyAuth;
use App\Models\Company;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StagesController extends Controller
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
    public function index()
    {
        $attributes = request()->validate([
            'company_id' => ['required',Rule::exists('companies','id')]
        ]);

        $company = Company::find($attributes['company_id']);

        if(!$this->changeValidator->validate($company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response(
            Stage::where(
                    'company_id',
                    '=',
                    request('company_id')
                )->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StageStoreRequest $request)
    {
        $attributes = $request->validated();

        $company = Company::find($attributes['company_id']);

        if(!$this->changeValidator->validate($company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response(
            Stage::create($attributes)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StageUpdateRequest $request, Stage $stage)
    {
        $attributes = $request->validated();

        if(!$this->changeValidator->validate($stage->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        if($attributes['company_id'] != $stage->company->id){
            return response(['message' => 'Forbidden'], 403);
        }
        $stage->update($attributes);

        return response($stage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        if(!$this->changeValidator->validate($stage->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $stage->delete();
        return response('No content',204);
    }

}
