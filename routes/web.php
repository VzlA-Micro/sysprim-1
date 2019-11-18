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
    if(Auth::guest()){
        return view('auth.login');
    }
    else {
        return view('home');
    }
});


Route::get('/online','HomeController@online');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// User module routes
Route::get('/user/register',array(
    'uses'=>'UserController@create',
    'as'=>'userRegister'
));

Route::post('/user/save',array(
    'uses'=>'UserController@store',
    'as'=>'userSave'
));

Route::get('/users/verify/{code}','UserController@verify');
Route::get('/profile', function() {
    return view('modules.users.profile');
})->name('profile');
Route::get('/users/manage', function() {
    return view('modules.users.menu');
})->name('users.manage');
Route::get('/users/register', function() {
    return view('modules.users.register');
})->name('users.register');

Route::get('/users/read',array(
    'as'=>'userRead',
    'uses'=>'UserController@show'
));

Route::get('/users/details/{id}',array(
    'as'=>'detailsUser',
    'uses'=>'UserController@edit'
));

Route::get('/users/editar/{id}',array(
    'as'=>'editarUser',
    'uses'=>'UserController@editar'
));

Route::post('/users/update/',array(
    'as'=>'updateUser',
    'uses'=>'UserController@update'
));

Route::get('/avatar/{filename}', 'UserController@getImage')->name('users.getImage');
Route::post('/set-image/{filename}', 'UserController@changeImage')->name('users.setImage');


Route::get('/users/find/{nationality}/{ci}','UserController@findUser');


//contribuyente module routes


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
Route::get('/companies/manage', function () {
    return view('modules.companies.manage');
})->name('companies.manage');

Route::get('/company/edit/{id}','CompaniesController@edit');
Route::post('/company/update','CompaniesController@update')->name('companies.update');
Route::get('/company/verify/{id}','CompaniesController@verifyTaxes');


// Companies taquillero


Route::get('ticketOffice/company/register','TicketOfficeController@registerCompany')->name('tickOffice.companies.register');
Route::post('ticketOffice/company/save','TicketOfficeController@storeCompany');
Route::get('ticketOffice/companies/all','TicketOfficeController@allCompanies')->name('companies.read');
Route::get('ticketOffice/companies/details/{id}','TicketOfficeController@detailsCompany')->name('tickOffice.companies.details');







// ---------------------------------------------------

// Vehicles module routes
Route::get('/vehicles/my-vehicles', function() {
    return view('modules.vehicles.manage');
})->name('vehicles.my-vehicles');
Route::get('/vehicles/register', function() {
    return view('modules.vehicles.register');
})->name('vehicles.register');
Route::get('/vehicles/read', function() {
    return view('modules.vehicles.read');
})->name('vehicles.read');

// ---------------------------------------------------

// Payments module routes
Route::get('/companies/my-payments/{company}', 'PaymentsController@menuPayments')->name('companies.my-payments');

Route::get('/payments/my-payments', function() {
    return view('modules.payments.menu');
})->name('payments.my-payments'); // Ruta de adorno, no borrar

Route::post('/payments/help', 'CompanyTaxesController@paymentsHelp')->name('payments.help');


Route::get('/payments/create/{company}','CompanyTaxesController@create')->name('payments.create');
Route::post('/payments/taxes','CompanyTaxesController@store')->name('taxes.save');
Route::get('/payments/taxes/{id}','CompanyTaxesController@show');
Route::get('/payments/calculate/{id}','CompanyTaxesController@calculate')->name('taxes.calculate');
Route::post('/payments/download/calculate','CompanyTaxesController@downloadCalculate')->name('taxes.calculate.download');
Route::get('/payments/history/{company}','CompanyTaxesController@history')->name('payments.history');

Route::get('/payments/reconcile', function () {
    return view('modules.payments.register');
})->name('payments.reconcile');

Route::get('/payments/manage', function() {
    return view('modules.payments.manage');
})->name('payments.manage');
Route::get('/payments/register', function() {
    return view('modules.payments.create');
})->name('payments.register');
Route::get('/payments/read', 'TicketOfficeController@taxesAll')->name('payments.read');
Route::get('/payments/details', function() {
    return view('modules.payments.details');
})->name('payments.details');

// ---------------------------------------------------------------
Route::get('payments/receipt', 'PaymentsTaxesController@getPDF')->name('payments.receipt');

Route::get('/bank/',function (){

    return view('dev.bank');
});

Route::post('/bank/import','BankController@import')->name('bank.import');
Route::get('/bank/verify','BankController@verifyPayments');
Route::get('/codigo-qr',function (){
   return view('dev.taxesQr');
});

Route::get('/cargar-ciu',function (){
    return view('modules.bank.upload');
});

Route::get('/pdf/{id}','CompanyTaxesController@getPdf');

// Group Ciiu module routes

Route::get('/ciu/manage', function() {
    return view('modules.ciiu-group.menu');
})->name('ciu.manage');

Route::get('/ciu/find/{ciu} ','CiuController@findCiu');


Route::get('/ciu-group/register', function() {
    return view('modules.ciiu-group.register');
})->name('ciu-group.register');
Route::post('/ciu-group/save','groupCiiuController@store')->name('ciu-group.save');
Route::get('/ciu-group/read','GroupCiiuController@show')->name('ciu-group.read');
Route::get('/ciu-branch/manage', function() {
    return view('modules.ciiu.menu');
})->name('ciu-branch.manage');

// Ciu module routes

Route::get('/ciu-branch/register','CiuController@index')->name('ciu-branch.register');
Route::post('/ciu-branch/save','CiuController@create')->name('ciu-branch.save');
Route::get('/ciu-branch/read','CiuController@show')->name('ciu-branch.read');
Route::get('/ciu-branch/details/{id}','CiuController@edit')->name('ciu-branch.details');
Route::post('/ciu-branch/update/{id}','CiuController@update')->name('ciu-branch.update');

Route::get('/ciu-branch/delete/{id}', 'CiuController@destroy')->name('ciu-branch.delete');

// Payments Taxes Module

Route::get('/paymentsTaxes-register/{id}',array(
    'as'=>'registerPayments',
    'uses'=>'PaymentsTaxesController@create'
));
Route::get('paymentsTaxes/pdf/','PaymentsTaxesController@pdf');
Route::post('paymentsTaxes/save',array(
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

Route::get('get-pdf/{pdf}',array(
    'as'=>'pdfImport',
    'uses'=>'PaymentsImportController@pdfImport'
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
Route::get('/fines-company/register/{id}', function() {
    return view('modules.fines-company.register');
})->name('fines-company.register');
Route::get('/read-fines-company',array(
    'as'=>'readFinesCompany',
    'uses'=>'FinesCompanyController@show'
));
Route::get('fines-company/read','FinesCompanyController@read')->name('fines-company.read');
Route::get('/fines-company/create/{id}','FinesCompanyController@create')->name('fines-company.create');
Route::post('/fines-company/save','FinesCompanyController@store')->name('fines-company.save');
Route::get('/fines-company/details/{id}','FinesCompanyController@edit')->name('fines-company.details');

// unidad tributaria module

Route::get('/tax-unit/manage', function() {
    return view('modules.tax-unit.manage');
})->name('tax-unit.manage');

Route::get('/tax-unit/register', function() {
    return view('modules.tax-unit.register');
})->name('tax-unit.register');
Route::post('/tax-unit/save','TributoController@store')->name('tax-unit.save');
Route::get('/tax-unit/read','TributoController@show')->name('tax-unit.read');

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

//Geosysprim
Route::get('/geosysprim/home','GeoSysprimController@home')->name('geosysprim');
Route::get('/geosysprim/find-company/solvent','GeoSysprimController@findCompanySolvent');
Route::get('/geosysprim/find-company/process','GeoSysprimController@findCompanyProcess');

Route::get('/admin/geolocation', function() {
    return view('modules.map.home');
})->name('admin.geolocation');

Route::get('/dashboard',array(
    'as'=>'dashboard',
    'uses'=>'DashboardController@dashboard'
));

Route::get('/notifications', function() {
    return view('modules.notifications.read');
})->name('notifications.read');
Route::get('/notifications/register', function() {
    return view('modules.notifications.register');
})->name('notifications.register');
Route::get('/notifications/show', function() {
    return view('modules.notifications.show');
})->name('notifications.show');
Route::get('/notifications/details', function() {
    return view('modules.notifications.details');
})->name('notifications.details');
Route::get('/notifications/manage', function() {
    return view('modules.notifications.manage');
})->name('notifications.manage');


Route::get('/payments/verify/manage', function() {
    return view('modules.bank.manage');
})->name('payments.verify.manage');

//Inmuebles
Route::get('/inmueble/my-property','PropertyController@index')->name('inmueble.my-property');

Route::get('/inmueble-register',array(
    'as'=>'registerInmueble',
    'uses'=>'PropertyController@create'
));

Route::post('/inmueble/save',array(
    'as'=>'saveInmueble',
    'uses'=>'PropertyController@store'
));

Route::post('/inmueble/verification',array(
    'as'=>'verificationCode',
    'uses'=>'PropertyController@verification'
));

Route::get('/inmueble/show/{id}',array(
    'as'=>'show.inmueble',
    'uses'=>'PropertyController@show'
));

Route::get('/inmueble/mi-inmueble','PropertyController@myProperty')->name('inmueble.my-propertys');

Route::get('/inmueble/my-inmueble/{id}',array(
    'uses'=>'PropertyTaxesController@create',
    'as'=>'propertyStatement'
));

Route::get('/inmueble/delaracion/{id}',array(
    'uses'=>'PropertyTaxesController@create',
    'as'=>'propertyStatement'
));

Route::get('/inmueble/statement/{id}',array(
    'uses'=>'PropertyTaxesController@create',
    'as'=>'propertyStatement'
));

Route::post('/inmueble/calcu',array(
    'uses'=>'PropertyTaxesController@calcu',
    'as'=>'propertyCalcu'
));

Route::post('/inmueble/calcuFraccionado',array(
    'uses'=>'PropertyTaxesController@calcuFraccionado',
    'as'=>'propertyCalcuFraccionado'
));

//verifyPaymentsBanks

Route::get('/fileBank-register', function() {
    return view('dev.verifyPaymentsBank.upload');
})->name('bank.upload');

Route::post('/fileBank/save',array(
    'as'=>'saveFileBank',
    'uses'=>'VerifyPaymentsBankImportController@importFile'
));

Route::get('/verified/payments',array(
    'as'=>'verifiedPayments',
    'uses'=>'VerifyPaymentsBankImportController@verifyPayments'
));

//taquilla
Route::get('/home/ticketOffice', function() {
    return view('modules.ticket-office.home');
})->name('home.ticket-office');


Route::get('/ticket-office/payments', function() {
    return view('modules.ticket-office.create');
})->name('ticket-office.payments');

Route::get('/ticket-office/view', function() {
    return view('modules.ticket-office.create');
})->name('ticket-office.payments');
Route::get('/ticket-office/cashier', 'TicketOfficeController@cashier')->name('cashier');
Route::get('/ticket-office/cashier/{id}', 'TicketOfficeController@QrTaxes');
Route::post('/ticket-office/payment/save', 'TicketOfficeController@paymentTaxes');
Route::post('/ticket-office/taxes/save', 'TicketOfficeController@registerTaxes');
Route::get('/ticket-office/find/code/{code}', 'TicketOfficeController@findCode');
Route::get('/ticket-office/find/fiscal-period/{fiscal_period}/{company_id}', 'TicketOfficeController@verifyTaxes');
Route::get('/ticket-office/find/user/{ci}', 'TicketOfficeController@findUser');


Route::get('/ticket-office/pdf/taxes/{id}', 'TicketOfficeController@pdfTaxes');




Route::get('/carnet', 'CompanyTaxesController@getCarnet')->name('carnet');



//Estadisticas
Route::get('/collection/statistics',array(
    'as'=>'collection',
    'uses'=>'DashboardController@collection'
));

Route::get('/dashboard',array(
    'as'=>'dashboard',
    'uses'=>'DashboardController@dashboard'
));

Route::get('bs',array(
   'as'=>'bs',
   'uses'=>'DashboardController@bs'
));

Route::get('amountApproximate',array(
    'as'=>'amountApproximate',
    'uses'=>'DashboardController@amountApproximate'
));


// Security routes

Route::get('/security', 
    function() {
        return view('modules.security.manage');
    }
)->name('security.manage');

// Roles routes 

Route::get('/roles/manage', function() {
    return view('modules.security.roles.manage');
})->name('roles.manage');
Route::get('/roles/register', function() {
    return view('modules.security.roles.register');
})->name('roles.register');
Route::get('/roles/read', function() {
    return view('modules.security.roles.read');
})->name('roles.read');


// Permissions routes

Route::get('/permissions/manage', function() {
    return view('modules.security.permissions.manage');
})->name('permissions.manage');
Route::get('/permissions/register', function() {
    return view('modules.security.permissions.register');
})->name('permissions.register');
Route::get('/permissions/read', function() {
    return view('modules.security.permissions.read');
})->name('permissions.read');

// Modules routes 
Route::get('/modules/manage', function() {
    return view('modules.security.modules.manage');
})->name('modules.manage');
Route::get('/modules/register', function() {
    return view('modules.security.modules.register');
})->name('modules.register');
Route::get('/modules/read', function() {
    return view('modules.security.modules.read');
})->name('modules.read');


Route::get('/bitacora', function() {
    return view('modules.security.history');
})->name('bitacora');

Route::get('/configuraciones/gestion', function() {
    return view('modules.settings.manage');
})->name('settings.manage');

// -------------- Colaborator routes
Route::get('/taxpayers/manage', function() {
    return view('modules.taxpayers.manage');
})->name('taxpayers.manage');

Route::get('/taxpayers/register', function() {
    return view('modules.taxpayers.register');
})->name('taxpayers.register');
Route::post('/taxpayers/save', 'UserController@storeTaxpayer')->name('taxpayers.save');
Route::get('/taxpayers/read', 'UserController@showTaxpayer')->name('taxpayers.read');
Route::get('/taxpayers/details/{id}', 'UserController@detailsTaxpayer')->name('taxpayers.details');
Route::post('/taxpayers/update/', 'UserController@updateTaxpayer')->name('taxpayers.update');
Route::post('/taxpayers/reset-password/', 'UserController@resetTaxpayerPassword')->name('taxpayers.reset-password');


Route::get('/help', function() {
    return view('modules.helps.manage');
})->name('helps.manage');