<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nabil;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[Nabil::class,'Dashboard']);
Route::get('/ViewUser',[Nabil::class,'ViewUser'])->name('employee.viewuser');
Route::get('/EditUser',[Nabil::class,'EditUser'])->name('employee.EditUser');
Route::get('/DeleteUser',[Nabil::class,'DeleteUser'])->name('employee.DeleteUser');
Route::get('/CreateUser',[Nabil::class,'CreateUser'])->name('employee.CreateUser');
Route::post('/CreateUserConfirm',[Nabil::class,'registersubmit'])->name('create_user.add');
Route::post('/EditUserSubmit',[Nabil::class,'EditUserSubmit'])->name('employee.EditUserSubmit');
Route::get('/DeleteUser',[Nabil::class,'DeleteUser'])->name('employee.DeleteUser');

Route::get('/ViewBuilding',[Nabil::class,'ViewBuilding'])->name('building.view');
Route::get('/EditBuilding',[Nabil::class,'EditBuilding'])->name('employee.EditBuilding');
Route::post('/EditBuildingSubmit',[Nabil::class,'EditBuildingSubmit'])->name('employee.EditBuildingSubmit');
Route::get('/FlatList',[Nabil::class,'FlatsList'])->name('Flats.List');
Route::get('/EditFlat',[Nabil::class,'EditFlat'])->name('employee.EditFlat');
Route::post('/EditFlatSubmit',[Nabil::class,'EditFlatSubmit'])->name('employee.EditFlatSubmit');
Route::get('/PrintBuildingRent',[Nabil::class,'PrintBuildingRent'])->name('buildingRent.print');
Route::get('/PrintBuildingElec',[Nabil::class,'PrintBuildingElec'])->name('buildingElec.print');
Route::get('/PrintBuildingWasa',[Nabil::class,'PrintBuildingWasa'])->name('buildingWasa.print');
Route::get('/ViewSubscription',[Nabil::class,'ViewSubscription'])->name('employee.ViewSubscription');
Route::get('/EditSubscription', [Nabil::class, 'EditSubscription'])->name('employee.EditSubscription');
Route::post('/EditSubscriptionConfirm',[Nabil::class,'EditSubscriptionConfirm'])->name('employee.EditSubscriptionConfirm');
Route::get('/SubNotify',[Nabil::class,'SubNotify'])->name('employee.SubNotify');
Route::get('/Login_view', [LoginController::class, 'Login_view'])->name('user.login');
Route::post('/Login',[LoginController::class,'Login'])->name('login.submit');
Route::get('/Logout', [LoginController::class, 'Logout'])->name('user.logout');
Route::get('/forgotpassword', [LoginController::class, 'forgotpass'])->name('user.forgotpass');
Route::post('/forgotpassSubmit',[LoginController::class,'forgotpassSubmit'])->name('user.forgotpassSubmit');
Route::get('/verifycred', [LoginController::class, 'verifycred']);
Route::get('/ResetPass', [LoginController::class, 'ResetPass']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

