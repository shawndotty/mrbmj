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

Route::get('/', function(){
	return redirect('/login'); 
});


Route::get('/admin', 'AdminController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/drivers', 'DriversController@index');
Route::post('/drivers/new', 'DriversController@store');
Route::get('/drivers/range-schedules', 'DriversController@indexWtihSchedules');
Route::get('/driver/{driver}', function(App\Driver $driver){
	return $driver;
});
Route::get('/driverschedules/{ds}', function(App\DriverSchedule $ds){
	return $ds;
});

Route::get('/guides', 'GuidesController@index');
Route::post('/guides/new', 'GuidesController@store');
Route::get('/guides/range-schedules', 'GuidesController@indexWtihSchedules');
Route::get('/guide/{guide}', function(App\Guide $guide){
	return $guide;
});
Route::get('/guideschedules/{gs}', function(App\GuideSchedule $gs){
	return $gs;
});

Route::get('/orders', 'OrdersController@index');
Route::get('/orders/in-range', 'OrdersController@indexWithRange');
Route::post('/orders/new', 'OrdersController@store');
Route::get('/order/{order}', function(App\Order $order){
	$order->load('vehicles','drivers','guides');
	return $order;
});

Route::get('/clients', 'ClientsController@index');
Route::post('/clients/new', 'ClientsController@store');
Route::get('/client/{client}', function(App\Client $client){
	$client->load('orders','invoices');
	return $client;
});

Route::get('/vehicles', 'VehiclesController@index');
Route::post('/vehicles/new', 'VehiclesController@store');
Route::get('/vehicel/{vehicle}', function(App\Vehicle $vehicle){
	return $vehicle;
});
Route::get('/vehicleschedules/{vs}', function(App\VehicleSchedule $vs){
	return $vs;
});
Route::get('/vehicles/range-schedules', 'VehiclesController@indexWtihSchedules');
Route::get('/vehicles/with-order-schedules', 'VehiclesController@indexWithOrderSchedules');
Route::get('/vehicles/schedules', 'VehicleSchedulesController@checkAvailableSchedules');

