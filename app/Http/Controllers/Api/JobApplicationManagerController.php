<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobApplicationManagerController extends Controller
{
    public function acceptCandidate(Request $request)
    {
        $attributes = $request->validate([
            'job_application_id' => ['required',Rule::exists('job_applications','id')],
        ]);

        $application = JobApplication::find($attributes);

        $application->accept();

        return response($application);

    }
}
