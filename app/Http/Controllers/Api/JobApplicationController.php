<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{

    public function index()
    {
        return response(JobApplication::all());
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'job_opening_id' => ['required',Rule::exists('job_openings','id')]
        ]);

        $attributes = array_merge(
            $attributes,
            ['user_id' => auth()->user()->getAttribute('id')]
        );

        return JobApplication::create($attributes);
    }

}
