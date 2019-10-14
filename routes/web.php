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
Route::get('/profile', function() {
    return view('modules.users.profile');
})->name('profile');
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
Route::get('/companies/my-payments/{company}', 'PaymentsController@menuPayments')->name('companies.my-payments');

Route::get('/payments/my-payments', function() {
    return view('modules.payments.menu');
})->name('payments.my-payments'); // Ruta de adorno, no borrar

Route::get('/payments/create/{company}','CompanyTaxesController@create')->name('payments.create');
Route::post('/payments/taxes','CompanyTaxesController@store')->name('taxes.save');
Route::get('/payments/taxes/{id}','CompanyTaxesController@show');
Route::get('/payments/history/{company}','CompanyTaxesController@history')->name('payments.history');
Route::get('/payments/reconcile', function () {
    return view('modules.payments.register');
})->name('payments.reconcile');


Route::get('/company/edit/{id}','CompaniesController@edit');
Route::post('/company/update','CompaniesController@update')->name('companies.update');
Route::get('/company/verify/{id}','CompaniesController@verifyTaxes');



Route::get('/bank/',function (){

    return view('dev.bank');
});

Route::post('/bank/import','BankController@import')->name('bank.import');
Route::get('/bank/verify','BankController@verifyPayments');
Route::get('/codigo-qr',function (){
   return view('dev.taxesQr');
});

Route::get('/pdf/{id}','CompanyTaxesController@getPdf');

// Group Ciiu module routes
Route::get('/group-ciiu-register', function() {
    return view('dev.groupCiiu.register');
})->name('groupCiiu.register');

Route::post('/save-GroupCiiu',array(
    'as'=>'saveGroupCiiu',
    'uses'=>'groupCiiuController@store'
));

Route::get('/read-GroupCiiu',array(
    'as'=>'readGroupCiiu',
    'uses'=>'GroupCiiuController@show'
));

// Ciu module routes

Route::get('/ciu-register', array(
    'as'=>'ciuRegister',
    'uses'=>'CiuController@index'
    ));

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

Route::get('/paymentsTaxes-register/{id}',array(
    'as'=>'registerPayments',
    'uses'=>'PaymentsTaxesController@create'
));

Route::post('/save-paymentsTaxes',array(
    'as'=>'savePaymentsTaxes',
    'uses'=>'PaymentsTaxesController@store'
));

Route::post('/update-paymentsTaxes/{id?}',array(
    'as'=>'updatePayments',
    'uses'=>'PaymentsTaxesController@edit'
));
//References bank module

Route::get('/referenceBank-register', function() {
   return view('modules.bank.upload');
})->name('bank.upload');

Route::post('/save-referenceBank',array(
   'as'=>'saveReferenceBank',
   'uses'=>'PaymentsImportController@importFile'
));
Route::get('/users/verify-ci/{ci}','UserController@verifyCi');
Route::get('/users/verify-email/{email}','UserController@verifyEmail');

Route::get('/company/verify-rif/{rif}','CompaniesController@verifyRif');
Route::get('/company/verify-license/{license}','CompaniesController@verifyLicense');

Route::get('/company/find/{rif}','CompaniesController@findCompany');


Route::post('ciu/filter-group','CiuController@filterCiu');
Route::get('/company/find/{rif}','CompaniesController@findCompany');
//Fines module routes

//Fines Company module routes
Route::get('/fines/manage', function() {
    return view('modules.fines.menu');
})->name('fines.manage');

Route::get('/fines/register', function() {
    return view('modules.fines.register');
})->name('fines.register');

Route::post('/fines/save', 'FinesController@create')->name('fines.save');
Route::get('/fines/read', 'FinesController@show')->name('fines.read');
Route::get('/fines/details/{id}', 'FinesController@edit')->name('fines.details');
Route::post('/fines/update/{id}', 'FinesController@update')->name('fines.update');
Route::get('/fines/delete/{id}', 'FinesController@destroy')->name('fines.delete');

// ------------------------ Fiscal
Route::get('/read-fines-company',array(
    'as'=>'readFinesCompany',
    'uses'=>'FinesCompanyController@show'
));

Route::get('/finesCompany-register/{id}', function() {
    return view('dev.finesCompany.register');
})->name('dev.finesCompany-register');


//Fines Company module routes

Route::get('/register-paymentsFines/{company}',array(
    'as'=>'registerPaymentsFines',
    'uses'=>'PaymentsFinesController@create'
));

Route::post('/save-paymentsFines',array(
    'as'=>'savePaymentsFines',
    'uses'=>'PaymentsFinesController@store'
));


// unidad tributaria module

Route::get('/undTributo-register', function() {
    return view('dev.tributo.register');
})->name('tributo.tributo-register');

Route::post('/save-tributo',array(
    'as'=>'saveTributo',
    'uses'=>'TributoController@store'
));

Route::get('/readTributo',array(
    'as'=>'readTributo',
    'uses'=>'TributoController@show'
));

// Employees Modules

Route::get('/employees-register', function() {
    return view('dev.employees.register');
})->name('employees.employees-register');

Route::post('/save-employees',array(
    'as'=>'saveEmployees',
    'uses'=>'EmployeesController@store'
));

Route::get('/readEmployees',array(
    'as'=>'readEmployees',
    'uses'=>'EmployeesController@show'
));

