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
Route::get('/companies/details/{id}', 'CompaniesController@details')->name('companies.details');
Route::get('/thumb/{filename}', 'CompaniesController@getImage')->name('companies.image');
Route::get('/companies/edit/{id}','CompaniesController@edit')->name('companies.edit');
Route::post('/companies/update','CompaniesController@update')->name('companies.update');
Route::get('/companies/verify/{id}','CompaniesController@verifyTaxes');

// ---------------------------------------------------

// Vehicles module routes
Route::get('/vehicles/my-vehicles', function() {
    return view('modules.vehicles.menu');
})->name('vehicles.my-vehicles');

// ---------------------------------------------------

// Payments module routes
Route::get('/companies/my-payments/{company}', function() {
    return view('modules.payments.menu');
})->name('companies.my-payments');

Route::get('/payments/my-payments', function() {
    return view('modules.payments.menu');
})->name('payments.my-payments'); // Ruta de adorno, no borrar

Route::get('/payments/create/{company}','CompanyTaxesController@create')->name('payments.create');
Route::post('/payments/taxes','CompanyTaxesController@store')->name('taxes.save');
Route::get('/payments/taxes/{id}','CompanyTaxesController@show');
Route::get('/payments/history/{company}','CompanyTaxesController@history');
Route::get('/payments/reconcile', function () {
    return view('modules.payments.register');
})->name('payments.reconcile');




// Ciu module routes
Route::get('/ciu-register', function() {
    return view('dev.registerCiu');
})->name('dev.ciu-register');

Route::post('/save-ciu',array(
   'as'=>'saveCiu',
   'uses'=>'CiuController@create'
));

Route::get('/read-ciu',array(
   'as'=>'readCiu',
   'uses'=>'CiuController@show'
));

Route::get('/details-ciu/{id}',array(
   'as'=>'detailsCiu',
   'uses'=>'CiuController@edit'
));

Route::post('/update-ciu/{id?}',array(
   'as'=>'updateCiu',
   'uses'=>'CiuController@update'
));

Route::get('/delete-ciu/{id}',array(
   'as'=>'deleteCiu',
   'uses'=>'CiuController@destroy'
));

// Payments Taxes Module

Route::get('/paymentsTaxes-register', function() {
   return view('dev.paymentsTaxes.register');
})->name('paymentsTaxes.paymentsTaxes-register');

Route::post('/save-paymentsTaxes',array(
   'as'=>'savePaymentsTaxes',
   'uses'=>'PaymentsTaxesController@store'
));

//References bank module

Route::get('/referenceBank-register', function() {
   return view('dev.registerReference');
})->name('dev.referencesBank-register');

Route::post('/save-referenceBank',array(
   'as'=>'saveReferenceBank',
   'uses'=>'PaymentsImportController@importFile'
));
