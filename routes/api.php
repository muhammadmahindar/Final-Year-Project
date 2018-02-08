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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::get('/user', function (Request $request) {
    // return $request->user();
	
	

	return response()->json([
		"msg" => "working"
	]);
// });	
})->middleware('auth:api');

Route::get('/userInfo', function (Request $request) {
    
	$email = "muhammadmahindar@gmail.com";
	$password ="secret";

	if(Auth::attempt(['email' => $email, 'password' => $password])) {
		// Authentication passed...

		$user = Auth::user();

		return response()->json([
			"user" => $user
		]);	
	}

	
	return response()->json([
		"user" => null
	]);
});	

Route::post('/test', function (Request $request) {
    
	$password = $request["password"];
	
	return response()->json([
		"msg" => $password
	]);
});


Route::resource('DailyProduction','Api\Production\DailyProductionApi');
Route::post('DailyProduction/create','Api\Production\DailyProductionApi@productselect')->name('DailyProduction.productselect');

Route::resource('GatePass','Api\GatePass\GatePassApi');
Route::resource('Production','Api\Production\ProductionControllerApi');
Route::get('/Pending/Productions','Api\Production\ProductionControllerApi@pending');
Route::get('/Approved/Productions','Api\Production\ProductionControllerApi@approved');
Route::get('/Completed/Productions','Api\Production\ProductionControllerApi@completed');

Route::get('/permissions',function(Request $request){
	$obj=$request->user()->id;
	$user=User::find($obj);
	$user->getAllPermissions();
	return $user;
})->middleware('auth:api');