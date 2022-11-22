<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthCompanyModification;
use App\Http\Services\Auth\ChangeValidator;
use App\Models\Company;
use App\Models\Stage;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    private ChangeValidator $changeValidator;

    public function __construct()
    {
        $this->changeValidator = new AuthCompanyModification();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = request()->validate([
            'company_id' => ['required']
        ]);

        $company = Company::find($attributes['company_id'])->first();

        if(!$this->changeValidator->validate($company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response(
            Stage::all()
                ->where(
                    'company_id',
                    '=',
                    request('company_id')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'unique:stages,name,NULL,NULL,company_id,' . request('company_id')],
            'company_id' => ['required', 'unique:stages,company_id,NULL,NULL,name,' . request('name')]
        ]);

        $company = Company::find($attributes['company_id'])->first();

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
