<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\JobOpeningController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function (){
    Route::apiResource('admin/companies',CompanyController::class);
    Route::apiResource('admin/job-openings',JobOpeningController::class);
});

Route::get('job-openings',[JobOpeningController::class,'index']);


Route::post('admin/register',[RegisterController::class,'admin']);
Route::post('company-admin/register',[RegisterController::class,'company']);

Route::post('admin/login',[RegisterController::class,'login']);
