<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\CompanyAuth;
use App\Mail\AcceptanceEmail;
use App\Models\Candidate;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private CompanyAuth $changeValidator;

    public function __construct(CompanyAuth $companyAuth)
    {
        $this->changeValidator = $companyAuth;
    }

    public function sendAcceptanceEmail(Candidate $candidate)
    {
        if(!$this->changeValidator->validate($candidate->job_opening->company)){
            return response(['message' => 'Forbidden'], 403);
        }
        Mail::to($candidate->user->email)->send(new AcceptanceEmail($candidate));
    }
}
