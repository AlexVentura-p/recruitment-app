<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\CandidateManagerController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\JobOpeningController;
use App\Http\Controllers\Api\StagesController;
use Illuminate\Http\Request;
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
    Route::post('stages',[StagesController::class,'store']);
    Route::get('stages',[StagesController::class,'index']);
    Route::apiResource('candidates',CandidateController::class)->except(['store']);
    Route::patch('job-applications/accept/{candidate}',[CandidateManagerController::class,'accept']);
    Route::patch('job-applications/reject/{candidate}',[CandidateManagerController::class,'reject']);
    Route::patch('job-applications/hire/{candidate}',[CandidateManagerController::class,'hire']);
    Route::post('candidate/stage',[CandidateManagerController::class,'changeStage']);
    Route::get('candidate/status/{candidate}',[CandidateManagerController::class,'showStatus']);
});

Route::middleware(['auth:api','checkRole:admin,admin-company,recruiter,candidate'])->group(function (){
    Route::post('candidates',CandidateController::class);
});

Route::get('job-openings',[JobOpeningController::class,'index']);

Route::post('register',[RegisterController::class,'register']);
Route::post('login',[RegisterController::class,'login']);
