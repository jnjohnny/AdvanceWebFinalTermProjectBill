<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MyAllAPIController;
use App\Models\colony;
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

Route::get('/getcolony',[MyAllAPIController::Class,'getColony']);
Route::POST('/addcolony',[MyAllAPIController::Class,'addColony']);
Route::POST('/deletecolony/{id}',[MyAllAPIController::Class,'deleteColony']);
Route::POST('/updatecolony/{id}',[MyAllAPIController::Class,'updateColony']);



Route::get('/getuser',[MyAllAPIController::Class,'getUser']);
Route::POST('/adduser',[MyAllAPIController::Class,'addUser']);
Route::POST('/updateuser/{id}',[MyAllAPIController::Class,'updateUser']);
Route::POST('/deleteuser/{id}',[MyAllAPIController::Class,'deleteUser']);


Route::get('/getflat',[MyAllAPIController::Class,'getFlat']);
Route::POST('/addflat',[MyAllAPIController::Class,'addFlat']);
Route::POST('/updateflat/{id}',[MyAllAPIController::Class,'updateFlat']);
Route::POST('/deleteflat/{id}',[MyAllAPIController::Class,'deleteFlat']);


Route::get('/getbuilding',[MyAllAPIController::Class,'getbuilding']);
Route::POST('/addbuilding',[MyAllAPIController::Class,'addabuilding']);
Route::POST('/editbuilding/{id}',[MyAllAPIController::Class,'EditBuilding']);
Route::POST('/editbuilding/{id}',[MyAllAPIController::Class,'getbuildingbyid']);
Route::POST('/deletebuilding/{id}',[MyAllAPIController::Class,'deletebuilding']);


Route::POST('/search',[MAWAbuildingsAPIController::Class,'searchh']);
