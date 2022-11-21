<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobOpeningCollection;
use App\Http\Resources\JobOpeningResource;
use App\Models\Company;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobOpeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'company_name' => ['required',Rule::exists('companies','name')],
            'position' => ['required'],
            'description' => ['required'],
            'deadline' => ['required']
        ]);

        $company = Company::where('name','=',$attributes['company_name'])->first();

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
    public function update(Request $request,JobOpening $jobOpening)
    {
        $attributes = $request->validate([
            'company_id' => ['required'],
            'position' => ['required'],
            'description' => ['required'],
            'deadline' => ['required']
        ]);

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
        $jobOpening->delete();
        return response('No content',204);
    }
}
