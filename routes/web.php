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

Route::get('/users/verify/{code}','UserController@verify');

// ---------------------------------------------------

// Companies module routes
Route::get('/companies/my-business','CompaniesController@index')->name('companies.my-business');
Route::get('/companies/register', 'CompaniesController@create')->name('companies.register');
Route::post('/companies/save', 'CompaniesController@store')->name('companies.save');
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

//dev

Route::get('/payments/create/{company}','CompanyTaxesController@create');
Route::post('/payments/taxes','CompanyTaxesController@store')->name('taxes.save');
Route::get('/payments/taxes/{id}','CompanyTaxesController@show');
Route::get('/payments/history/{company}','CompanyTaxesController@history');


Route::get('/company/edit/{id}','CompaniesController@edit');
Route::post('/company/update','CompaniesController@update')->name('companies.update');
Route::get('/company/verify/{id}','CompaniesController@verifyTaxes');
