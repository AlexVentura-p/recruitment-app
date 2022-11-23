<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Candidate\CandidateController;
use App\Http\Controllers\Api\Candidate\CandidateManagerController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\JobOpeningController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\StagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api','checkRole:admin' ])->group(function (){
    Route::apiResource('admin/companies',CompanyController::class);
});

Route::middleware(['auth:api','checkRole:admin,admin-company,recruiter'])->group(function (){
    Route::apiResource('admin/job-openings',JobOpeningController::class);
    Route::apiResource('stages',StagesController::class,);
    Route::get('candidates',[CandidateController::class,'index']);
    Route::get('candidates/{candidate}',[CandidateController::class,'show']);
    Route::delete('candidates/{candidate}',[CandidateController::class,'destroy']);
    Route::patch('candidates/accept/{candidate}',[CandidateManagerController::class,'accept']);
    Route::patch('candidates/reject/{candidate}',[CandidateManagerController::class,'reject']);
    Route::patch('candidates/hire/{candidate}',[CandidateManagerController::class,'hire']);
    Route::post('candidate/stage',[CandidateManagerController::class,'changeStage']);
    Route::get('candidate/status/{candidate}',[CandidateManagerController::class,'showStatus']);
    Route::post('register',[RegisterController::class,'register']);
    Route::get('acceptanceEmail/{candidate}',[MailController::class,'sendAcceptanceEmail']);
});

Route::middleware(['auth:api','checkRole:admin,admin-company,recruiter,candidate'])->group(function (){
    Route::post('candidates',[CandidateController::class,'store']);
});

Route::get('job-openings/{job_opening}',[JobOpeningController::class,'show']);
Route::get('job-openings',[JobOpeningController::class,'index']);
Route::post('registerCandidate',[RegisterController::class,'registerCandidate']);

Route::post('login',[RegisterController::class,'login']);
