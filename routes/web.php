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

use Illuminate\Support\Facades\Redis;

use Carbon\Carbon;
use App\Http\Controllers\YaoDate;


use App\User;
use App\VehicleType;
use App\SimulationDetail;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index');

Route::get('/roles', 'RoleController@index');
Route::post('/roles/store', 'RoleController@store');
Route::post('/roles/update', 'RoleController@update');
Route::post('/roles/changeState', 'RoleController@changeState');

Route::get('/users', 'UserController@index');
Route::post('/users/update', 'UserController@update');
Route::post('/users/store', 'UserController@store');
Route::post('/users/changeState', 'UserController@changeState');

Route::get('/taxes', 'TaxController@index');
Route::post('/taxes/store', 'TaxController@store');
Route::post('/taxes/update', 'TaxController@update');
Route::post('/taxes/changeState', 'TaxController@changeState');

Route::get('/prices', 'PriceController@index');
Route::post('/prices/store', 'PriceController@store');
Route::post('/prices/update', 'PriceController@update');
Route::post('/prices/changeState', 'PriceController@changeState');

Route::get('/vehicle_types', 'VehicleTypeController@index');
Route::post('/vehicle_types/store', 'VehicleTypeController@store');
Route::post('/vehicle_types/update', 'VehicleTypeController@update');
Route::post('/vehicle_types/changeState', 'VehicleTypeController@changeState');

Route::get('/parkings', 'ParkingController@index');
Route::post('/parkings/store', 'ParkingController@store');
Route::get('/parkings/show/{id}', 'ParkingController@show');
Route::post('/parkings/update', 'ParkingController@update');
Route::post('/parkings/changeState', 'ParkingController@changeState');

Route::get('/movements', 'MovementController@index');

Route::get('/simulations', 'SimulationController@index');
Route::get('/simulations/show/{id}', 'SimulationController@show');
Route::post('/simulations/store', 'SimulationController@store');
Route::get('/simulations/start', 'SimulationController@startSimulation');
Route::post('/simulations/monthly_earnings', 'SimulationController@computeMonthlyEarnings');
Route::get('/simulations/completed', 'SimulationController@completed');
