<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nabil;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NabilEmployeeAPIController;

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

Route::get('/Employee/ViewUser',[NabilEmployeeAPIController::class,'ViewUser']);
Route::post('/Employee/AddUser',[NabilEmployeeAPIController::class,'AddUser']);
Route::post('/Employee/EditUser',[NabilEmployeeAPIController::class,'EditUser']);

Route::get('/Employee/ViewColony',[NabilEmployeeAPIController::class,'ViewColony']);
Route::get('/Employee/GetColony/{id}',[NabilEmployeeAPIController::class,'GetColony']);
Route::post('/Employee/AddColony',[NabilEmployeeAPIController::class,'AddColony']);
Route::post('/Employee/EditColony',[NabilEmployeeAPIController::class,'EditColony']);

Route::get('/Employee/ViewBuilding',[NabilEmployeeAPIController::class,'ViewBuilding']);
Route::post('/Employee/AddBuilding',[NabilEmployeeAPIController::class,'AddBuilding']);
Route::get('/Employee/GetBuilding/{id}',[NabilEmployeeAPIController::class,'GetBuilding']);
Route::post('/Employee/EditBuilding',[NabilEmployeeAPIController::class,'EditBuilding']);

