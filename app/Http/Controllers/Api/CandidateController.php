<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateCollection;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{

    public function index()
    {
        return CandidateCollection::make(
            Candidate::paginate(10)
        );
    }

    public function store(Request $request)
    {
        $userId = ['user_id' => auth()->user()->getAttribute('id')];

        $attributes = $request->validate([
            'job_opening_id' => [
                'required',
                Rule::exists('job_openings', 'id'),
                'unique:candidates,job_opening_id,NULL,NULL,user_id,' . $userId['user_id']]
        ]);

        $attributes = array_merge(
            $attributes,
            $userId
        );

        return CandidateResource::make(
            Candidate::create($attributes)
        );
    }

    public function show(Candidate $candidate)
    {
        return CandidateResource::make($candidate);
    }

}
