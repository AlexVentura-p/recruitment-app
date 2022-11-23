<?php

namespace App\Http\Controllers\Api\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\ChangeStageRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Services\Auth\AuthCandidateModification;
use App\Http\Services\Auth\CompanyAuth;
use App\Mail\AcceptanceEmail;
use App\Models\Candidate;
use App\Models\Stage;
use Illuminate\Support\Facades\Mail;

class CandidateManagerController extends Controller
{

    private CompanyAuth $changeValidator;

    public function __construct(CompanyAuth $companyAuth)
    {
        $this->changeValidator = $companyAuth;
    }

    public function accept(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        $candidate->accept();
        $candidate->update();
        Mail::to($candidate->user->email)->send(new AcceptanceEmail($candidate));
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
        $candidate = Candidate::find($attributes['candidate_id']);

        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $stage = Stage::where('name', '=', $attributes['stage'])
            ->where('company_id', '=', $candidate->job_opening->company->id)->first();

        if ($stage ?? false) {
            $candidate->stage_id = $stage->id;
            $candidate->update();
            return CandidateResource::make($candidate);
        }

        return response(['message' => 'Unregistered stage']);

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
