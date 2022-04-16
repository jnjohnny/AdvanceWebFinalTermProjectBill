<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MawabuildingsAPIController;
use App\Models\building;
use App\Models\flat;
use App\Models\login;


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

//Login & Registration
Route::POST('/login',[MAWAbuildingsAPIController::Class,'login']);
Route::POST('/register',[MAWAbuildingsAPIController::Class,'register']);


//Building Table CRUD
Route::get('/getbuilding',[MAWAbuildingsAPIController::Class,'getallbuilding'])->middleware('APIAuthentication');
Route::POST('/addbuilding',[MAWAbuildingsAPIController::Class,'addbuilding']);
Route::POST('/editbuilding/{id}',[MAWAbuildingsAPIController::Class,'EditBuilding']);
Route::POST('/deletebuilding/{id}',[MAWAbuildingsAPIController::Class,'deletebuilding']);



//Flats Table CRUD
Route::get('/getflat',[MAWAbuildingsAPIController::Class,'getallflat']);
Route::POST('/addflat',[MAWAbuildingsAPIController::Class,'addflat']);
Route::POST('/editflat/{id}',[MAWAbuildingsAPIController::Class,'EDITFlat']);
Route::POST('/deleteflat/{id}',[MAWAbuildingsAPIController::Class,'deleteflat']);


//currentBill Table CRUD
Route::get('/getCurrent',[MAWAbuildingsAPIController::Class,'getallCurrent']);
Route::POST('/addCurrent',[MAWAbuildingsAPIController::Class,'addCurrent']);
Route::POST('/deleteCurrent/{id}',[MAWAbuildingsAPIController::Class,'deleteCurrent']);



//WasaBill Table CRUD
Route::get('/getwasa',[MAWAbuildingsAPIController::Class,'getallwasa']);
Route::POST('/addwasa',[MAWAbuildingsAPIController::Class,'addwasa']);
Route::POST('/editwasa/{id}',[MAWAbuildingsAPIController::Class,'Editwasa']);
Route::POST('/deletewasa/{id}',[MAWAbuildingsAPIController::Class,'deletewasa']);




//Email
Route::Post('/Sendemail',[MAWAbuildingsAPIController::Class,'mailsending']);


//Search
Route::POST('/getbuilding/{id}',[MAWAbuildingsAPIController::Class,'getonebuilding'])->middleware('APIAuthentication');
Route::POST('/getflat/{id}',[MAWAbuildingsAPIController::Class,'getoneflat']);
Route::POST('/getCurrent/{id}',[MAWAbuildingsAPIController::Class,'getoneCurrent']);
Route::get('/search/{name}',[MAWAbuildingsAPIController::Class,'search']);
Route::POST('/search',[MAWAbuildingsAPIController::Class,'searchh']);  //HateOS API
Route::POST('/deteletuser/{id}',[MAWAbuildingsAPIController::Class,'deleteuser']);

