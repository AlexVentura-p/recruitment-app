<?php

namespace App\Http\Controllers\Api\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateRequest;
use App\Http\Resources\CandidateCollection;
use App\Http\Resources\CandidateResource;
use App\Http\Services\Auth\CompanyAuth;
use App\Models\Candidate;
use App\Models\JobOpening;

class CandidateController extends Controller
{
    private CompanyAuth $changeValidator;

    public function __construct(CompanyAuth $companyAuth)
    {
        $this->changeValidator = $companyAuth;
    }

    public function index()
    {
        request()->validate([
            'company_id' => ['required']
        ]);

        $jobOpenings = JobOpening::where('company_id','=',request('company_id'))
            ->get('id');

        if (auth()->user()->role->name == 'admin' ||
            auth()->user()->company_id == request('company_id')) {
            return CandidateCollection::make(
                Candidate::whereIn('job_opening_id',$jobOpenings)
                    ->paginate(10)
            );
        }

        return response(['message' => 'Forbidden'], 403);

    }

    public function store(StoreCandidateRequest $request)
    {
        $attributes = $request->validated();
        $user = auth()->user();

        if ($user->role->name != 'candidate'){
            return response(['message' => 'Applicant should have candidate user'], 403);
        }

        return CandidateResource::make(
            Candidate::create([
                'user_id' => $user->id,
                'job_opening_id' => $attributes['job_opening_id']
            ])
        );
    }

    public function show(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        return CandidateResource::make($candidate);
    }

    public function destroy(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $candidate->delete();
        return response('No content',204);
    }

}
