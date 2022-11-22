<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\ChangeStageRequest;
use App\Http\Resources\CandidateCollection;
use App\Http\Resources\CandidateResource;
use App\Http\Services\Auth\AuthCandidateModification;
use App\Http\Services\Auth\AuthCompanyModification;
use App\Http\Services\Auth\ChangeValidator;
use App\Models\Candidate;

class CandidateManagerController extends Controller
{

    private ChangeValidator $changeValidator;

    public function __construct()
    {
        $this->changeValidator = new AuthCompanyModification();
    }

    public function accept(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        $candidate->accept();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function reject(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        $candidate->reject();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function hire(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        $candidate->hire();
        $candidate->update();
        return CandidateResource::make($candidate);
    }

    public function changeStage(ChangeStageRequest $request)
    {
        $attributes = $request->validated();

        $candidate = Candidate::find($attributes['candidate_id'])->first();

        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $candidate->setStage($attributes['stage'],$attributes['company_id']);

        return CandidateResource::make($candidate);
    }

    public function showStatus(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        return response([
            'status' => $candidate->status
        ]);
    }
}
