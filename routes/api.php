<?php

use Illuminate\Http\Request;
use App\User;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('DailyProduction','Api\Production\DailyProductionApi');
Route::post('DailyProduction/create','Api\Production\DailyProductionApi@productselect')->name('DailyProduction.productselect');

Route::resource('GatePass','Api\GatePass\GatePassApi');
Route::resource('Production','Api\Production\ProductionControllerApi');
Route::get('/Pending/Productions','Api\Production\ProductionControllerApi@pending');
Route::get('/Approved/Productions','Api\Production\ProductionControllerApi@approved');
Route::get('/Completed/Productions','Api\Production\ProductionControllerApi@completed');
