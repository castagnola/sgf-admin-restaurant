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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/**
 * Resources Routes
 */
Route::resource('restaurants', 'Restaurant\RestaurantController')->middleware('auth');
Route::resource('bookings', 'Booking\BookingController')->middleware('auth');
Route::resource('tables', 'Table\TableController')->middleware('auth');

/**
 * Custom Routes
 */

Route::post('restaurants/{restaurant}', 'Restaurant\RestaurantController@update')->name('restaurant.edit')->middleware('auth');
Route::post('tables/{table}', 'Table\TableController@update')->name('table.edit')->middleware('auth');
Route::post('bookings/create', 'Booking\BookingController@show')->name('booking.generate')->middleware('auth');
Route::post('bookings/add', 'Booking\BookingController@add')->name('booking.add')->middleware('auth');
Route::post('bookings/getTables', 'Booking\BookingController@getTables')->name('booking.getTables')->middleware('auth');
