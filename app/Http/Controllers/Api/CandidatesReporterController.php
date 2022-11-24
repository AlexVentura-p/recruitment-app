<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\CandidateDateRequest;
use App\Http\Requests\Reports\StageReportRequest;
use App\Http\Services\Auth\CompanyAuth;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Stage;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidatesReporterController extends Controller
{
    private CompanyAuth $changeValidator;

    public function __construct(CompanyAuth $companyAuth)
    {
        $this->changeValidator = $companyAuth;
    }

    public function stage(StageReportRequest $request)
    {
        $attributes = $request->validated();

        $stage = Stage::where('name','=',$attributes['stage'])
            ->where('company_id','=',$attributes['company_id'])->first();

        if(!$this->changeValidator->validate($stage->company)){
            return response(['message' => 'Forbidden'], 403);
        }

        $candidates = Candidate::with('job_opening')
            ->with('user')
            ->with('stage')
            ->where('stage_id','=',$stage->id)
            ->get();

        return $this->sendCandidatesReport($candidates);

    }

    public function candidates(CandidateDateRequest $request)
    {
        $attributes = $request->validated();

        $company = Company::where('id','=',$attributes['company_id'])->first();

        if(!$this->changeValidator->validate($company)){
            return response(['message' => 'Forbidden'], 403);
        }

        if ($attributes['from_date'] > $attributes['to_date']){
            return response(['message' => 'Invalid date range']);
        }

        $candidates = Candidate::whereBetween(
            'created_at',
            [
                $attributes['from_date'],
                $attributes['to_date']
            ]
        )->with('job_opening')
            ->with('user')
            ->with('stage')->get();

        return $this->sendCandidatesReport($candidates);

    }

    private function sendCandidatesReport($candidates)
    {
        $pdf = Pdf::loadView('reporter.candidates-reporter',[
            'candidates' => $candidates
        ])->setPaper('a4','landscape');

        return $pdf->download('candidates.pdf');
    }


}
