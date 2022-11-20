<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CandidateManagerController extends Controller
{

    public function accept(Candidate $candidate)
    {
        $candidate->accept();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function reject(Candidate $candidate)
    {
        $candidate->reject();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function hire(Candidate $candidate)
    {
        $candidate->hire();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function changeStage(Request $request)
    {
        $attributes = $request->validate([
            'candidate_id' => ['required',Rule::exists('candidates','id')],
            'stage' => ['required',Rule::exists('stages','name')],
            'company_id' => ['required',Rule::exists('companies','id')]
        ]);

        $candidate = Candidate::find($attributes['candidate_id'])->first();

        $candidate->setStage($attributes['stage'],$attributes['company_id']);

        return CandidateResource::make($candidate);
    }

    public function showStatus(Candidate $candidate)
    {
        return response([
            'status' => $candidate->status
        ]);
    }
}
