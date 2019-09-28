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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// User module routes
Route::get('/users/register', function() {
    return view('modules.users.register');
})->name('users.register');

// ---------------------------------------------------

// Companies module routes
Route::get('/companies/my-business', function() {
    return view('modules.companies.menu');
})->name('companies.my-business');
Route::get('/companies/register', function() {
    return view('modules.companies.register');
})->name('companies/register');

// ---------------------------------------------------

// Vehicles module routes
Route::get('/vehicles/my-vehicles', function() {
    return view('modules.vehicles.menu');
})->name('vehicles.my-vehicles');

// ---------------------------------------------------

// Payments module routes
Route::get('/payments/my-payments', function() {
    return view('modules.payments.menu');
})->name('payments.my-payments');