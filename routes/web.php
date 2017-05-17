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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

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

Route::get('/simulations/test', 'SimulationController@testSimulation');


Route::get('/dates', function() {

    $in = Carbon::create(2010, 10, 10, 17, 45);
    $out = Carbon::create(2010, 10, 10, 18, 29);

    echo $in->diffInMinutes($out);
    exit;

    $in = Carbon::create(2010, 10, 10, 17, 03);
    $out = Carbon::create(2010, 10, 13, 15, 15);

    echo YaoDate::computePrice(1);
    // echo $in->diffInDays($out);
    // echo YaoDate::minimumTime($in, $out);
    exit();

    echo YaoDate::isClosed($out);


    exit();

    $limit_1 = Carbon::parse($out);


    $limit_1->hour = 23;
    $limit_1->minute = 0;


    $limit_2 = Carbon::parse($out);
    $limit_2->addDay();
    $limit_2->hour = 5;
    $limit_2->minute = 59;


    echo '<br>';
    echo $limit_1;
    echo '<br>';
    echo $limit_2;
    echo '<br>';

    // var_dump(Carbon::create(2012, 9, 5, 3)->between($first, $second));
    echo($out->between($limit_1, $limit_2));

    echo "<br>";
    echo "<br>";
    echo "<br>";

    $in = Carbon::create(2012, 9, 5, 9, 32, 10);
    $out = Carbon::create(2012, 9, 7, 8, 00, 10);
    echo ceil($in->diffInHours($out) / 24);
    exit();
});


Route::get('/redis', function() {
    // $visits = Redis::incr('visits');
    //
    // Redis::set('foo', 'bar');
    //

    // Redis::flushAll();
    // exit();

    // $vehicle_types_list = Redis::lPush('vtList', '3');
    // $list = Redis::lPush('vtList', '2');
    // $list = Redis::lPush('vtList', '1');
    //
    // dd(Redis::lRange('vtList', 0, -1));
    // exit();
    //
    // return $list;
    //
    // $foo = Redis::get('foo');
    //
    // // echo Redis::exists('foo');;
    //
    // Redis::hSet('user:manuel', 'name', 'Manuel F. Del Toro');
    // // $value = Redis::hGet('user:manuel', 'name');
    // $value = Redis::hGetAll('user:manuel');
    // $value = Redis::hVals('user:manuel');
    //
    //
    // return $value;

    // Redis::lPush('k1' , 'A');
    // Redis::lPush('k1' , 'A');
    // Redis::lPush('k1' , 'C');
    // Redis::lPush('k1' , 'D');
    // Redis::lPush('k1' , 'E');

    // dd(Redis::lRange('k1', 0, -1));

    // Redis::hSet('user:manuel', 'age', 20);
    // Redis::hIncrBy('user:manuel', 'age', 3);

    // var_dump(Redis::hGetAll('user:manuel'));




});

Route::get('/dude', function() {

    // $list = array();
    //
    // $o1 = array(
    //     'simulation_id' => 1,
    //     'parking_id' => 1,
    //     'vehicle_type_id' => 2,
    //     'movement_id' => 1,
    //     'vehicle_id' => 324,
    //     'in_date' => Carbon::now(),
    //     'comment' => 'Este es un comment',
    //     'created_at' => Carbon::now()
    // );
    //
    // DB::table("simulation_details")->insert($o1);
    //
    // $o2 = array(
    //     'simulation_id' => 1,
    //     'parking_id' => 2,
    //     'vehicle_type_id' => 2,
    //     'movement_id' => 2,
    //     'vehicle_id' => 324,
    //     'out_date' => Carbon::now()->addDay(),
    //     'comment' => 'null',
    //     'created_at' => Carbon::now()
    // );
    //
    // DB::table("simulation_details")->insert($o2);

    // var_dump($list);
    //
    // exit;

    $detail = new SimulationDetail();
    $detail->simulation_id = 1; // Cambiar, poner dinámico
    $detail->parking_id = 1;
    $detail->vehicle_type_id = 3;
    $detail->movement_id = 1;
    $detail->in_date = Carbon::now()->addDay();
    $detail->vehicle_id = 15;
    $detail->created_at = Carbon::now()->addDay();

    // var_dump($detail->toArray());
    // exit();

    DB::table("simulation_details")->insert($detail->toArray());



});

Route::get('/names', function() {

    YaoDate::computePrice(1);

    $vt = App\VehicleType::find(1);

    foreach ($vt->prices as $price) {
        echo $price->name . "----->" . $price->pivot->value;
    }

});
