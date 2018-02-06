<?php
use App\OauthClient;

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
//Reports
Route::get('/Reports','Reports\MonthlyReport@ProductSelect');
Route::post('/Reports/DailyView','Reports\MonthlyReport@ShowDaily')->name('Reports.Graph');
Route::get('/Reports/MonthlyReport','Reports\MonthlyReport@ShowForm');

Route::post('Reports/MonthlyView','Reports\MonthlyReport@ShowMonthly')->name('Reports.Month');

Route::post('Message/{id}','Auth\Profile\ProfileController@SendMessage');
Route::post('SendMessage/{id}','Auth\Profile\ProfileController@MessageToDB');
Route::post('ShowMessage/{id}','Auth\Profile\ProfileController@ShowMessage');

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();
Route::get('/MarkRead',function(){
	foreach (Auth::user()->unReadNotifications as $value) {
		if ($value->type=='App\Notifications\ProductionApproved' || $value->type=='App\Notifications\PendingProduction') {
			$value->markAsRead();
		}
		
	}
	return redirect('/');
})->middleware('auth');
Route::get('/AndroidSecret', function () {
    $temp= OauthClient::findOrFail(2);
    return $temp->secret;
})->middleware('auth');
//Admin Routes
Route::resource('Role','Role\RoleController');
Route::resource('Users','Auth\UserController'); //
Route::post('/getbranch','Auth\RegisterController@getbranch');
Route::post('/getdepartment','Auth\RegisterController@getdepartment');

//User With Roles Route
Route::get('/home', 'HomeController@index');
//Company Management Route
Route::resource('Company','Company\CompanyController');
Route::resource('Branch','Branch\BranchController');
Route::resource('Department','Department\DepartmentController');
//Production Routes
Route::resource('Material','Material\MaterialController');
Route::resource('Product','Product\ProductController');
Route::resource('Production','Production\ProductionController');
Route::post('DailyProduction/create','Production\DailyProduction@productselect')->name('DailyProduction.productselect');
Route::resource('DailyProduction','Production\DailyProduction');
Route::get('/Pending/Productions','Production\ProductionController@pending');
Route::get('/ShowPending/Productions/{id}','Production\ProductionController@ShowPending');
Route::get('/Approved/Productions','Production\ProductionController@approved');
Route::get('/ShowApproved/Productions/{id}','Production\ProductionController@showapproved');
Route::get('/DisApproved/Productions/{id}','Production\ProductionController@disapproved');
Route::get('/Completed/Productions','Production\ProductionController@completed');
Route::resource('Production-Approval','Production\ProductionApproval');
//GatePass routes
Route::resource('GatePass','GatePass\GatePassController');
//Cost Calculation Route
Route::resource('SemiFixed','Cost\SemiFixedController');
Route::resource('FactoryOverhead','Cost\FactoryOverheadController');
//Profile Routes
Route::resource('Profile','Auth\Profile\ProfileController');
Route::post('changepassword/{id}','Auth\Profile\ProfileController@changepassword');
