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

use App\User;

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

Route::get('/movements', 'MovementController@index');
Route::get('/simulations', 'SimulationController@index');


Route::get('/redis', function() {
    $visits = Redis::incr('visits');

    Redis::set('foo', 'bar');

    $foo = Redis::get('foo');

    return $foo;


});

Route::get('/dude', function() {

    $faker = Faker\Factory::create();
    $map = new \Ds\Map();

    for ($i=0; $i < 5; $i++) {
        $user = new User();
        $user->id = $i;
        $user->name = $faker->name;
        // dd($user);



        $map->put($i, $user);
    }

    echo json_encode($map);

    echo '</br>';
    echo '</br>';
    echo '</br>';

    $map->remove(0);

    echo($map->get(1));

    echo json_encode($map);

});
