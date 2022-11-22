<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateRequest;
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

    public function store(StoreCandidateRequest $request)
    {

        $attributes = $request->validated();

        if (auth()->user()->company_id ?? false) {
            if (auth()->user()->company_id != $attributes['company_id']) {
                return response(['message' => 'Forbidden'], 403);
            }
        }

        return CandidateResource::make(
            Candidate::create($attributes)
        );
    }

    public function show(Candidate $candidate)
    {
        if (auth()->user()->company_id != $candidate->company_id) {
            return response(['message' => 'Forbidden'], 403);
        }
        return CandidateResource::make($candidate);
    }

}
