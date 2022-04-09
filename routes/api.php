<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MawabuildingsAPIController;
use App\Models\building;
use App\Models\flat;


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

//Building Table CRUD
Route::get('/getbuilding',[MAWAbuildingsAPIController::Class,'getallbuilding']);
Route::POST('/addbuilding',[MAWAbuildingsAPIController::Class,'addbuilding']);
Route::POST('/getbuilding/{id}',[MAWAbuildingsAPIController::Class,'getonebuilding']);
Route::POST('/deletebuilding/{id}',[MAWAbuildingsAPIController::Class,'deletebuilding']);



//Flats Table CRUD
Route::get('/getflat',[MAWAbuildingsAPIController::Class,'getallflat']);
Route::POST('/addflat',[MAWAbuildingsAPIController::Class,'addflat']);
Route::POST('/getflat/{id}',[MAWAbuildingsAPIController::Class,'getoneflat']);
Route::POST('/deleteflat/{id}',[MAWAbuildingsAPIController::Class,'deleteflat']);


//currentBill Table CRUD
Route::get('/getCurrent',[MAWAbuildingsAPIController::Class,'getallCurrent']);
Route::POST('/addCurrent',[MAWAbuildingsAPIController::Class,'addCurrent']);
Route::POST('/getCurrent/{id}',[MAWAbuildingsAPIController::Class,'getoneCurrent']);
Route::POST('/deleteCurrent/{id}',[MAWAbuildingsAPIController::Class,'deleteCurrent']);

