<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(JobOpening::paginated(10));
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
            'company_id' => ['required'],
            'position' => ['required'],
            'description' => ['required'],
            'deadline' => ['required']
        ]);

        return response(
            JobOpening::create($attributes),
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
        return response($jobOpening);
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

        return response($jobOpening);
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
