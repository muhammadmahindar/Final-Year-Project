<?php

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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();
//Admin Routes
Route::resource('Role','Role\RoleController');
Route::resource('Users','Auth\UserController'); //
Route::post('/getbranch','Auth\RegisterController@getbranch');
Route::post('/getdepartment','Auth\RegisterController@getdepartment');

//User With Roles Route
Route::get('/home', 'HomeController@index');

Route::resource('Company','Company\CompanyController');
Route::resource('Branch','Branch\BranchController');
Route::resource('Department','Department\DepartmentController');

Route::resource('Material','Material\MaterialController');
Route::resource('Product','Product\ProductController');
Route::resource('Production','Production\ProductionController');
Route::get('/Pending/Productions','Production\ProductionController@pending');
Route::get('/Approved/Productions','Production\ProductionController@approved');
Route::get('/Completed/Productions','Production\ProductionController@completed');
Route::resource('Production-Approval','Production\ProductionApproval');

Route::resource('GatePass','GatePass\GatePassController');
Route::resource('Profile','Auth\Profile\ProfileController');
Route::post('changepassword/{id}','Auth\Profile\ProfileController@changepassword');
