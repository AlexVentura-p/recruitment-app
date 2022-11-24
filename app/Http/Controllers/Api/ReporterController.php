<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\StageReportRequest;
use App\Http\Resources\CandidateCollection;
use App\Models\Candidate;
use App\Models\Stage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class ReporterController extends Controller
{

    public function stage(StageReportRequest $request)
    {

        $attributes = $request->validated();

        $stage = Stage::where('name','=',$attributes['stage'])
            ->where('company_id','=',$attributes['company_id'])->first();

        $candidates = Candidate::with('job_opening')
            ->with('user')->with('stage')
            ->where('stage_id','=',$stage->id)->get();

        $pdf = Pdf::loadView('reporter.stage-reporter',[
            'candidates' => $candidates
        ])->setPaper('a4','landscape');

        return $pdf->download('candidates.pdf');

    }


}
