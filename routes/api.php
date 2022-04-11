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

Route::get('/ViewUser',[NabilEmployeeAPIController::class,'ViewUser']);
Route::post('/CreateUserConfirm',[NabilEmployeeAPIController::class,'registersubmit']);
Route::post('/EditUserSubmit',[NabilEmployeeAPIController::class,'EditUserSubmit']);

Route::get('/ViewBuilding',[NabilEmployeeAPIController::class,'ViewBuilding']);
Route::get('/GetBuilding/{id}',[NabilEmployeeAPIController::class,'GetBuilding']);
Route::get('/EditBuilding',[NabilEmployeeAPIController::class,'EditBuilding']);
Route::post('/EditBuildingSubmit',[NabilEmployeeAPIController::class,'EditBuildingSubmit']);

Route::get('/FlatList',[NabilEmployeeAPIController::class,'FlatsList']);
Route::get('/EditFlat',[NabilEmployeeAPIController::class,'EditFlat']);
Route::post('/EditFlatSubmit',[NabilEmployeeAPIController::class,'EditFlatSubmit']);

Route::get('/PrintBuildingRent',[NabilEmployeeAPIController::class,'PrintBuildingRent']);
Route::get('/PrintBuildingElec',[NabilEmployeeAPIController::class,'PrintBuildingElec']);
Route::get('/PrintBuildingWasa',[NabilEmployeeAPIController::class,'PrintBuildingWasa']);
Route::get('/ViewSubscription',[NabilEmployeeAPIController::class,'ViewSubscription']);
Route::get('/EditSubscription', [NabilEmployeeAPIController::class, 'EditSubscription']);
Route::post('/EditSubscriptionConfirm',[NabilEmployeeAPIController::class,'EditSubscriptionConfirm']);
Route::get('/SubNotify',[NabilEmployeeAPIController::class,'SubNotify'])->name('employee.SubNotify');

Route::get('/Login_view', [LoginController::class, 'Login_view'])->name('user.login');
Route::post('/Login',[LoginController::class,'Login'])->name('login.submit');
Route::get('/Logout', [LoginController::class, 'Logout'])->name('user.logout');
Route::get('/forgotpassword', [LoginController::class, 'forgotpass'])->name('user.forgotpass');
Route::post('/forgotpassSubmit',[LoginController::class,'forgotpassSubmit'])->name('user.forgotpassSubmit');
Route::get('/verifycred', [LoginController::class, 'verifycred']);
Route::get('/ResetPass', [LoginController::class, 'ResetPass']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
