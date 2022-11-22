<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobOpening\StoreJobOpeningRequest;
use App\Http\Requests\JobOpening\UpdateJobOpeningRequest;
use App\Http\Resources\JobOpeningCollection;
use App\Http\Resources\JobOpeningResource;
use App\Http\Services\Auth\AuthCompanyModification;
use App\Http\Services\Auth\ChangeValidator;
use App\Models\Company;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobOpeningController extends Controller
{
    private ChangeValidator $changeValidator;

    public function __construct()
    {
        $this->changeValidator = new AuthCompanyModification();
    }
    /**
     * Display a listing of company by name.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attributes = $request->validate([
            'company_name' => ['nullable',Rule::exists('companies','name')]
        ]);

        if ($attributes['company_name'] ?? false){

            $company = Company::where('name','=',$attributes['company_name'])->first();
            return JobOpeningCollection::make(
                JobOpening::where('company_id','=',$company->id)->paginate(10)
            );

        }

        return JobOpeningCollection::make(
            JobOpening::paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobOpeningRequest $request)
    {
        $attributes = $request->validated();

        $company = Company::where('name','=',$attributes['company_name'])->first();

        if(!$this->changeValidator->validate($company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response(
            JobOpening::create([
                'company_id' => $company->id,
                'position' => $attributes['position'],
                'description' => $attributes['description'],
                'deadline' => $attributes['deadline']
            ]),
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  JobOpening $jobOpening
     * @return \Illuminate\Http\Response
     */
    public function show(JobOpening $jobOpening)
    {
        return JobOpeningResource::make($jobOpening);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  JobOpening $jobOpening
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobOpeningRequest $request,JobOpening $jobOpening)
    {

        if(!$this->changeValidator->validate($jobOpening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $attributes = $request->validated();

        if($attributes['company_id'] != $jobOpening->company->id){
            return response(['message' => 'Forbidden'], 403);
        }

        $jobOpening->update($attributes);

        return JobOpeningResource::make($jobOpening);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  JobOpening $jobOpening
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOpening $jobOpening)
    {
        if(!$this->changeValidator->validate($jobOpening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $jobOpening->delete();
        return response('No content',204);
    }

}
