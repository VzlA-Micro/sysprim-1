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
    if (Auth::guest()) {
        return view('auth.login');
    } else {
        return view('home');
    }
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/online', 'HomeController@online');
Auth::routes();


Route::get('/users/verify/{code}', 'UserController@verify');

Route::get('/users/verify-ci/{ci}', 'UserController@verifyCi');

Route::get('/users/verify-email/{email}/{id?}', 'UserController@verifyEmail');
Route::get('/users/find/{nationality}/{ci}', 'UserController@findUser');

Route::middleware(['auth'])->group(function () {


    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::get('/download/{file}', 'HomeController@downloadPdf')->name('download');

    // Usuarios
    Route::group(['middleware' => ['permission:Gestionar Usuarios']], function () {
        // Nivel 1: Gestionar Usuario
        Route::get('/users/manage', 'UserController@index')->name('users.manage');


        // Nivel 2: Registro y Consulta
        Route::group(['middleware' => ['permission:Registar Usuario|Consultar Usuarios']], function () {
            Route::get('/users/register', 'UserController@create')->name('users.register');
            Route::post('/users/save', 'UserController@store')->name('users.save');
            Route::get('/users/read', 'UserController@show')->name('users.read');
            // Nivel 3: Detalles
            Route::group(['middleware' => ['permission:Detalles Usuarios']], function () {
                Route::get('/users/details/{id}', 'UserController@edit')->name('users.details');
                Route::group(['middleware' => ['permission:Actualizar Usuarios|Habilitar/Deshabilitar Usuarios|Resetar Usuarios']], function () {
                    Route::post('/users/update/', 'UserController@update')->name('users.update');
                    Route::get('/users/account/{id}/{status}', 'UserController@enableDisableAccount');
                    Route::post('/users/reset-password/', 'UserController@resetUserPassword')->name('users.reset-password');
                });
            });
        });

    });

    Route::get('/avatar/{filename}', 'UserController@getImage')->name('users.getImage');
    Route::post('/users/setImage', 'UserController@changeImage')->name('users.setImage');
    Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');
    Route::post('/profile/setPassword', 'UserController@resetUserPassword')->name('profile.setPassword');


    // Configuración
    Route::group(['middleware' => ['permission:Configuración']], function () {
        // Nivel 1: Configuración (Gestion)
        Route::get('/configuraciones/gestion', function () {
            return view('modules.settings.manage');
        })->name('settings.manage');
        // Nivel 2: CIIU y UTC
        Route::group(['middleware' => ['permission:Gestionar Unidad Tribuaria|Gestionar CIIU']], function () {
            Route::get('/ciu/manage', function () {
                return view('modules.ciiu-group.menu');
            })->name('ciu.manage');
            Route::get('/tax-unit/manage', function () {
                return view('modules.tax-unit.manage');
            })->name('tax-unit.manage');
        });

        // Nivel 3: Registro y Consulta
        Route::group(['middleware' => ['permission:Registar Unidad Tribuaria|Consultar Unidades Tribuarias']], function () {
            Route::get('/tax-unit/register', function () {
                return view('modules.tax-unit.register');
            })->name('tax-unit.register');
            Route::post('/tax-unit/save', 'TributoController@store')->name('tax-unit.save');
            Route::get('/tax-unit/read', 'TributoController@show')->name('tax-unit.read');
        });

        Route::group(['middleware' => ['permission:Registar Grupo CIIU|Consultar Grupos CIIU|Gestionar Ramos CIIU']], function () {
            Route::get('/ciu-group/register', function () {
                return view('modules.ciiu-group.register');
            })->name('ciu-group.register');
            Route::post('/ciu-group/save', 'groupCiiuController@store')->name('ciu-group.save');
            Route::get('/ciu-group/read', 'GroupCiiuController@show')->name('ciu-group.read');
            Route::get('/ciu-branch/manage', function () {
                return view('modules.ciiu.menu');
            })->name('ciu-branch.manage');
            // Nivel 4 (Gestionar Ramo CIIU)
            Route::group(['middleware' => ['permission:Registar Ramo CIIU|Consultar Ramos CIIU']], function () {
                Route::get('/ciu-branch/register', 'CiuController@index')->name('ciu-branch.register');
                Route::post('/ciu-branch/save', 'CiuController@create')->name('ciu-branch.save');
                Route::get('/ciu-branch/read', 'CiuController@show')->name('ciu-branch.read');
                // Nivel 5 (Detalles)
                Route::group(['middleware' => ['permission:Detalles Ramo CIIU|Actualizar Ramos CIIU']], function () {
                    Route::get('/ciu-branch/details/{id}', 'CiuController@edit')->name('ciu-branch.details');
                    Route::post('/ciu-branch/update', 'CiuController@update')->name('ciu-branch.update');
                    // Route::get('/ciu-branch/delete/{id}', 'CiuController@destroy')->name('ciu-branch.delete');
                });
            });
        });

        // Gestionar Accesorios
        Route::get('accessories/manage', 'AccessoriesController@manage')->name('accessories.manage');
        Route::get('accessories/register', 'AccessoriesController@create')->name('accessories.register');
        Route::post('accessories/save', 'AccessoriesController@store')->name('accessories.save');
        Route::get('accessories/read', 'AccessoriesController@show')->name('accessories.read');
        Route::get('accessories/details/{id}', 'AccessoriesController@details')->name('accessories.details');
        Route::post('accessories/update', 'AccessoriesController@update')->name('accessories.update');


        // GEstionar tipos de publicidad
        Route::get('advertising-type/manage', 'AdvertisingTypeController@manage')->name('advertising-type.manage');
        Route::get('advertising-type/register', 'AdvertisingTypeController@create')->name('advertising-type.register');
        Route::post('advertising-type/save', 'AdvertisingTypeController@store')->name('advertising-type.save');
        Route::get('advertising-type/read', 'AdvertisingTypeController@show')->name('advertising-type.read');
        Route::get('advertising-type/details/{id}', 'AdvertisingTypeController@details')->name('advertising-type.details');
        Route::post('advertising-type/update', 'AdvertisingTypeController@update')->name('advertising-type.update');
    

    });

    // GeoSysPRIM

    Route::group(['middleware' => ['permission:GeoSEMAT']], function () {
        Route::get('/geosysprim/home', 'GeoSysprimController@home')->name('geosysprim');
        Route::get('/geosysprim/find-company/solvent', 'GeoSysprimController@findCompanySolvent');
        Route::get('/geosysprim/find-company/process', 'GeoSysprimController@findCompanyProcess');
        Route::get('/geosysprim/find-company/process', 'GeoSysprimController@findCompanyProcess');
        Route::get('/geosysprim/find-company/registered', 'GeoSysprimController@CompanyRegistered');
        Route::get('/geosysprim/find-company/solvent-process', 'GeoSysprimController@CompanyProcessVerified');
    });


    // Estadisticas 
    Route::group(['middleware' => ['permission:Estadisticas']], function () {
        Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
        Route::get('bs', 'DashboardController@bs')->name('bs');
        Route::get('amountApproximate', 'DashboardController@amountApproximate')->name('amountApproximate');
        Route::get('dearTaxes', 'DashboardController@dearTaxes')->name('dearTaxes');
    });
    Route::get('/collection/statistics', 'DashboardController@collection')->name('collection');




    // Route::get('/dashboard',array(
    //     'as'=>'dashboard',
    //     'uses'=>'DashboardController@dashboard'
    // ));


    // Taquilla
    Route::group(['middleware' => ['permission:Taquilla']], function () {
        Route::get('/home/ticketOffice', function () {
            return view('modules.ticket-office.home');
        })->name('home.ticket-office');

        // Nivel 1: Gestionar Contrubuyente, Pagos y Empresas
        Route::group(['middleware' => ['permission:Gestionar Contribuyentes']], function () {
            Route::get('/taxpayers/manage', function () {
                return view('modules.taxpayers.manage');
            })->name('taxpayers.manage');

            // Nivel 2: Registrar Y Consultar
            Route::group(['middleware' => ['permission:Registar Contribuyente|Consultar Contribuyentes']], function () {
                Route::get('/taxpayers/register', function () {
                    return view('modules.taxpayers.register');
                })->name('taxpayers.register');
                Route::post('/taxpayers/save', 'UserController@storeTaxpayer')->name('taxpayers.save');
                Route::get('/taxpayers/read', 'UserController@showTaxpayer')->name('taxpayers.read');

                // Nivel 3: Detalles
                Route::group(['middleware' => ['permission:Detalles Contribuyentes']], function () {
                    Route::get('/taxpayers/details/{id}', 'UserController@detailsTaxpayer')->name('taxpayers.details');
                    // Nivel 4: Actualizar, Resetear, Habilitar
                    Route::group(['middleware' => ['permission:Actualizar Contribuyentes|Habilitar/Deshabilitar Contribuyentes|Resetar Contribuyentes']], function () {
                        Route::post('/taxpayers/update/', 'UserController@updateTaxpayer')->name('taxpayers.update');
                        Route::post('/taxpayers/reset-password/', 'UserController@resetTaxpayerPassword')->name('taxpayers.reset-password');
                    });
                });
            });
        });

        // Gestionar Pagos
        Route::group(['middleware' => ['permission:Gestionar Pagos']], function () {
            // Nivel 1: Generar planilla, pagar planilla, Ver pagos y ver planillas
            Route::get('/ticket-office/payments', function () {
                return view('modules.ticket-office.create');
            })->name('ticket-office.payments');
            Route::get('/ticket-office/taxes/', 'TicketOfficeController@getTaxes')->name('ticket-office.taxes.getTaxes');
            Route::get('/ticket-office/payment/web', 'TicketOfficeController@paymentsWeb')->name('ticket-office.pay.web');
            Route::get('/ticket-office/type-payment', function () {
                return view('modules.payments.type_payment');
            })->name('ticket-office.type.payments');
            Route::get('/ticket-office/cashier/{id}', 'TicketOfficeController@QrTaxes');

            // Nivel 2: 
            // ---- Generar Planilla -> Registrar
            Route::group(['middleware' => ['permission:Generar Planilla']], function () {
                Route::post('/ticket-office/taxes/save', 'TicketOfficeController@registerTaxes');
            });
            // ---- Pagar Planilla -> Registrar
            Route::group(['middleware' => ['permission:Pagar Planilla']], function () {
                Route::post('/ticket-office/payment/save', 'TicketOfficeController@paymentTaxes');
            });
            // ---- Ver Pagos 
            Route::group(['middleware' => ['permission:Ver Pagos']], function () {
                Route::get('/ticket-office/payments/{type}', 'TicketOfficeController@payments')->name('ticket-office.payment.type');
                Route::get('/ticket-office/payments/checks', function () {
                    return view('modules.payments.checks');
                })->name('ticket-office.payment.type.checks');
                // Nivel 3: Detalles de planilla
                Route::group(['middleware' => ['permission:Detalles Pagos']], function () {
                    Route::get('/ticket-office/payments/details/{id}', 'TicketOfficeController@paymentsDetails')->name('ticket-office.payment.details');
                    Route::get('/ticket-office/payments/change/{id}/{status}', 'TicketOfficeController@changeStatustaxes');
                });
            });

        });


        // Gestionar Empresas
        Route::group(['middleware' => ['permission:Gestionar Empresas']], function () {
            // Nivel 1: Gestionar Empresas
            Route::get('/companies/manage', function () {
                return view('modules.companies.manage');
            })->name('companies.manage');
            // Nivel 2: Registrar y Consultar
            Route::group(['middleware' => ['permission:Registar Empresa|Consultar Empresas']], function () {
                Route::get('ticketOffice/company/register', 'TicketOfficeController@registerCompany')->name('tickOffice.companies.register');
                Route::post('ticketOffice/company/save', 'TicketOfficeController@storeCompany');
                Route::get('ticketOffice/companies/all', 'TicketOfficeController@allCompanies')->name('companies.read');
                // Nivel 3: Detalles
                Route::group(['middleware' => ['permission:Detalles Empresas']], function () {
                    Route::get('ticketOffice/companies/details/{id}', 'TicketOfficeController@detailsCompany')->name('tickOffice.companies.details');
                    // Nivel 4: Actualizar 
                    Route::group(['middleware' => ['permission:Actualizar Empresas']], function () {
                        // Poner rutas de edicion aqui
                    });
                });
            });
        });


        Route::get('company/ciu/{id_ciu}/{company_id}/{status}', 'CompaniesController@changeStatusCiiu');

        Route::post('company/update/map', 'CompaniesController@updatedMap');


        // Verificacion de Pagos
        Route::group(['middleware' => ['permission:Verificar Pagos - Archivo']], function () {
            Route::get('/payments/verify/manage', function () {
                return view('modules.bank.manage');
            })->name('payments.verify.manage');
            Route::get('/ticket-office/cashier', 'TicketOfficeController@cashier')->name('cashier');


            // Nivel 1: Cargar Archivo
            Route::group(['middleware' => ['permission:Cargar Archivo Pagos']], function () {
                Route::get('/fileBank-register', function () {
                    return view('modules.bank.upload');
                })->name('bank.upload');
                Route::post('/bank-veryfy/save', 'VerifyPaymentsBankImportController@importFile')->name('bank.verify');
            });
            // Nivel 2: Ver Pagos Verificados
            Route::group(['middleware' => ['permission:Ver Pagos verificados']], function () {
                Route::get('/bank/verified-payments', 'VerifyPaymentsBankImportController@verifyPayments')->name('bank.read');

            });
        });





    });

    /*-----------Cambiar Status de pagos--------------*/

    Route::get('/payments/change-status/{id}/{status}','TicketOfficeController@changeStatusPayment');



    Route::get('/ticket-office/my-payments/{type}', 'TicketOfficeController@myPaymentsTickOffice')->name('ticket-office.payment');
    Route::get('/ticket-office/find/code/{code}', 'TicketOfficeController@findCode');
    Route::get('/ticket-office/find/fiscal-period/{fiscal_period}/{company_id}', 'TicketOfficeController@verifyTaxes');
    Route::get('/ticket-office/find/user/{ci}', 'TicketOfficeController@findUser');
    Route::get('/ticket-office/pdf/taxes/{id}', 'TicketOfficeController@pdfTaxes');
    Route::get('/ticket-office/generate-receipt/{taxes}', 'TicketOfficeController@generateReceipt');
    Route::get('/ticket-office/taxes/calculate/{taxes_data}', 'TicketOfficeController@calculatePayments');


// Route::get('/ticket-office/payments/change/{id}/{status}','TicketOfficeController@changeStatustaxes');


    // Seguridad
    Route::group(['middleware' => ['permission:Seguridad']], function () {
        Route::get('/security', 'SecurityController@index')->name('security.manage');
        // Nivel 1: Gestionar Roles y Ver Bitacora
        Route::group(['middleware' => ['permission:Gestionar Roles y Permisos|Bitacora']], function () {
            Route::get('/roles/manage', 'Permissions\RoleController@index')->name('roles.manage');
            Route::get('/audits', 'SecurityController@audits')->name('audits');
            Route::get('/audits', 'SecurityController@audits')->name('audits');

            // Nivel 2: Registrar y Consultar
            Route::group(['middleware' => ['permission:Gestionar Roles y Permisos|Bitacora']], function () {
                Route::get('/roles/register', 'Permissions\RoleController@create')->name('roles.register');
                Route::post('/roles/save', 'Permissions\RoleController@store')->name('roles.save');
                Route::get('/roles/read', 'Permissions\RoleController@show')->name('roles.read');
                // Nivel 3: Detalles y Actualizacion
                Route::group(['middleware' => ['permission:Detalles Roles']], function () {
                    Route::get('/roles/details/{id}', 'Permissions\RoleController@details')->name('roles.details');
                    // Nivel 4: Actualizar
                    Route::group(['middleware' => ['permission:Actualizar Roles']], function () {
                        Route::post('/roles/update', 'Permissions\RoleController@update')->name('roles.update');
                    });
                });
            });
        });
    });

    // Notificaciones
    Route::group(['middleware' => ['permission:Notificaciones']], function () {
        // Nivel 1: Gestionar
        Route::get('/notifications/manage', 'NotificationController@index')->name('notifications.manage');
        // Nivel 2: Registrar y consultar
        Route::group(['middleware' => ['permission:Registrar Notificaciones|Consultar Notificaciones']], function () {
            Route::get('/notifications/register', 'NotificationController@create')->name('notifications.register');
            Route::post('/notifications/save', 'NotificationController@store')->name('notifications.save');
            Route::get('/notifications/show', 'NotificationController@show')->name('notifications.show');
        });

    });
    Route::get('/notifications/read', function () {
        return view('modules.notifications.read');
    })->name('notifications.read');
    Route::get('/notifications/details', function () {
        return view('modules.notifications.details');
    })->name('notifications.details');

    // Mi Publicidad
    Route::get('/publicity/my-publicity', 'PublicityController@show')->name('publicity.my-publicity');
    Route::get('/publicity/register', 'PublicityController@create')->name('publicity.register');


    // Mis Empresas
    Route::group(['middleware' => ['permission:Mis Empresas|Consultar Mis Empresas']], function () {
        // Nivel 1: Mis Empresas
        Route::get('/companies/my-business', 'CompaniesController@index')->name('companies.my-business');
        Route::get('/companies/details/{id}', 'CompaniesController@details')->name('companies.details');
        Route::get('/thumb/{filename}', 'CompaniesController@getImage')->name('companies.image');
        Route::get('/companies/carnet/{id}', 'CompaniesController@getCarnet')->name('companies.carnet');
        // Nivel 2: Registrar y Ver Detalles
        Route::group(['middleware' => ['permission:Registar Mis Empresas']], function () {
            Route::get('/companies/register', 'CompaniesController@create')->name('companies.register');
            Route::post('/companies/save', 'CompaniesController@store')->name('companies.save');
        });
        // Nivel 3: Actualizar
        Route::group(['middleware' => ['permission:Detalles Mis Empresas']], function () {
            Route::get('/companies/edit/{id}', 'CompaniesController@edit')->name('companies.edit');
        });

    });

    // Mis Inmuebles
    Route::group(['middleware' => ['permission:Mis Inmuebles|Consultar Mis Inmuebles']], function () {
        // Nivel 1: Mis Inmuebles
        Route::get('/properties/my-properties', 'PropertyController@index')->name('properties.my-properties');
        // Nivel 2: Registrar y Ver Detalles
        Route::group(['middleware' => ['permission:Registar Mis Inmuebles']], function () {
            Route::get('/properties/register', 'PropertyController@create')->name('properties.register');
            Route::post('/properties/save', 'PropertyController@store')->name('properties.save');
        });
        // Nivel 3: Detalles
        Route::group(['middleware' => ['permission:Detalles Mis Inmuebles']], function () {

        });
    });


    //Inmuebles
    Route::post('/properties/verification', 'PropertyController@verification')->name('properties.verification');

    Route::get('/inmueble/show/{id}', array(
        'as' => 'show.inmueble',
        'uses' => 'PropertyController@show'
    ));
    Route::get('/inmueble/mi-inmueble', 'PropertyController@myProperty')->name('inmueble.my-propertys');


    Route::get('/inmueble/my-inmueble/{id}', array(
        'uses' => 'PropertyTaxesController@create',
        'as' => 'propertyStatement'
    ));

    Route::get('/inmueble/delaracion/{id}', array(
        'uses' => 'PropertyTaxesController@create',
        'as' => 'propertyStatement'
    ));

    Route::get('/inmueble/statement/{id}', array(
        'uses' => 'PropertyTaxesController@create',
        'as' => 'propertyStatement'
    ));

    Route::post('/inmueble/calcu', array(
        'uses' => 'PropertyTaxesController@calcu',
        'as' => 'propertyCalcu'
    ));


    // Mis Vehiculos
    //Route::group(['middleware' => ['permission:Mis Vehiculos|Consultar Mis Vehiculos']], function () {
    // Nivel 1: Mis Vehiculos

    //});
//__________________________________Vehicles Type module routes_______________________________________________________
    Route::get('/vehicles/type-vehicles', function () {
        return view('modules.vehicle_type.manage');
    })->name('vehicles.type.vehicles');

    Route::get('/vehicles/register-type', function () {
        return view('modules.vehicle_type.register');
    })->name('vehicles.type.register');

    Route::post('/type-vehicles/save', 'VehicleTypeController@store')->name('typeVehicles.save');

    Route::get('/type-vehicles/details/{id}', 'VehicleTypeController@edit')->name('typeVehicle.details');

    Route::post('/type-vehicles/update', 'VehicleTypeController@update')->name('typeVehicles.update');

    Route::get('/type-vehicles/read', 'VehicleTypeController@show')->name('type-vehicles.read');

// ______________________________________________________________________________________________________


//_________________________Vehicles module routes_______________________________________________________
    // Nivel 2: Registrar Vehiculos
    //Route::group(['middleware' => ['permission:Registar Mis Vehiculos']], function () {

    //});

    // Nivel 3: Detalles de vehiculos
    //Route::group(['middleware' => ['permission:Detalles Mis Vehiculos']], function () {

    //  });


    // Companies module routes
    Route::post('/companies/update', 'CompaniesController@update')->name('companies.update');

    Route::get('/companies/verify/{id}', 'CompaniesController@verifyTaxes');

    Route::get('/company/edit/{id}', 'CompaniesController@edit');

    Route::get('/company/verify/{id}', 'CompaniesController@verifyTaxes');

    Route::post('/company/update', 'CompaniesController@update')->name('companies.update');


    Route::post('/company/addCiiu', 'Companiescontroller@addCiiu')->name('companies.addCiiu');
    Route::get('/company/change-status/{id}/{status}', 'CompaniesController@changeStatus');


//________________________module Vehicle_____________________________


    Route::get('/vehicles/register', 'VehicleController@create')->name('vehicles.register');
    Route::post('/vehicles/save', 'VehicleController@store')->name('Vehicles.save');


    Route::get('/vehicles/read', 'VehicleController@show')->name('vehicles.read');
    Route::get('/vehicles/my-vehicles', 'VehicleController@show')->name('vehicles.my-vehicles');
    Route::get('/thumb/{filename}', 'VehicleController@getImage')->name('vehicles.image');

    Route::post('/vehicles/update', 'VehicleTypeController@update')->name('typeVehicles.update');
    Route::post('/vehicles/searchBrand', 'VehicleController@brand')->name('vehicle.searchModel');
    Route::post('/vehicles/verifyLicense', 'VehicleController@licensePlate')->name('vehicle.licensePlate');
    Route::post('/vehicles/verifyBodySerial', 'VehicleController@bodySerial')->name('vehicle.bodySerial');
    Route::post('/vehicles/verifySerialEngine', 'VehicleController@serialEngine')->name('vehicle.serialEngine');
    Route::get('/vehicles/details/{id}', 'VehicleController@edit')->name('vehicles.details');

    // ---------------------------------------------------


    // Payments module routes
    Route::get('/companies/my-payments/{company}', 'PaymentsController@menuPayments')->name('companies.my-payments');

    Route::get('/payments/my-payments', function () {
        return view('modules.payments.menu');
    })->name('payments.my-payments'); // Ruta de adorno, no borrar


//___________________________Models Vehicles modules routes_______________________________________________________
    Route::get('/vehicles/models-vehicles', function () {
        return view('modules.vehicles_models.manage');
    })->name('vehicles.models.vehicles');

    Route::get('/vehicles-models/register', 'ModelsVehicleController@create')->name('vehicles.models.register');
    Route::post('/vehicles-models/save', 'ModelsVehicleController@store')->name('vehicles.register.save');

    Route::get('/vehicles-models/read', 'ModelsVehicleController@show')->name('vehicles.models.read');
    Route::get('/vehicles-models/details/{id}', 'ModelsVehicleController@edit')->name('vehicles.models.details');
    Route::post('/vehicles-models/update', 'ModelsVehicleController@update')->name('vehicles.models.update');
//_________________________________________________________________________________________________


//___________________________Brands Vehicles modules routes_______________________________________________________
    Route::get('/vehicles/brands-vehicles', function () {
        return view('modules.vehicles_brand.manage');
    })->name('vehicles.brand.manage');

    Route::get('/vehicles-brand/register', 'BrandVehicleController@create')->name('vehicles.brand.register');
    Route::post('/vehicles-brand/save', 'BrandVehicleController@store')->name('vehicles.brand.save');

    Route::get('/vehicles-brand/read', 'BrandVehicleController@show')->name('vehicles.brand.read');
    Route::get('/vehicles-brand/details/{id}', 'BrandVehicleController@edit')->name('vehicles.brand.details');
    Route::post('/vehicles-brand/update', 'BrandVehicleController@update')->name('vehicles.brand.update');
    Route::post('/vehicles-brand/verifyBrand', 'BrandVehicleController@verifyBrand')->name('vehicles.brand.verifyBrand');
//___________________________________________________________________________________________________________________________


//_____________________________________________Recharge modules routes_______________________________________________________

    Route::get('/recharges', function () {
        return view('modules.recharge.manage');
    })->name('recharge.manage');
    Route::get('/recharges/register', 'RechargeController@create')->name('recharge.register');
    Route::post('/recharge/save', 'RechargeController@store')->name('recharge.save');
    Route::get('/recharge/read', 'RechargeController@show')->name('recharge.read');
    Route::get('/recharge/details/{id}', 'RechargeController@edit')->name('recharge.details');
    Route::post('/recharge/update', 'RechargeController@update')->name('recharge.update');
    Route::post('/recharge/verifyBrand', 'RechargeController@verifyBrand')->name('recharge.verifyBrand');

//___________________________________________________________________________________________________________________________

//_______________________________________Vehicles Taxes Routes_______________________________________________________________
    Route::get('/taxes/vehicles/{id}', 'VehiclesTaxesController@create')->name('taxes.vehicle');
    Route::post('/vehicle/taxes/save', 'VehiclesTaxesController@taxesSave')->name('vehicles.taxes.save');
    Route::post('/vehicle/payments/register', 'VehiclesTaxesController@payments')->name('vehicle.payments.store');
//___________________________________________________________________________________________________________________________


    Route::get('/payments/create/{company}/{type?}', 'CompanyTaxesController@create')->name('payments.create');

    Route::post('/payments/taxes', 'CompanyTaxesController@store')->name('taxes.save');
    Route::get('/payments/taxes/{id}', 'CompanyTaxesController@show');
    Route::get('/payments/calculate/{id}', 'CompanyTaxesController@calculate')->name('taxes.calculate');
    Route::post('/payments/download/calculate', 'CompanyTaxesController@downloadCalculate')->name('taxes.calculate.download');
    Route::get('/payments/history/{company}', 'CompanyTaxesController@history')->name('payments.history');
    Route::post('/payments/register', 'CompanyTaxesController@payments')->name('payments.store');
    Route::post('/payments/taxes/save', 'CompanyTaxesController@taxesSave')->name('company.taxes.save');
    Route::get('/payments/taxes/download/{id}', 'CompanyTaxesController@downloadPDF')->name('taxes.download');




    //_______________________________________DEFINITIVE COMPANY TAXES _______________________________________________________________
    Route::post('/taxes/definitive/store','CompanyTaxesController@storeDefinitive')->name('taxes.save.definitive');//registro

    Route::get('/taxes/definitive/{id}','CompanyTaxesController@detailsDefinitive')->name('taxes.details.definitive');//detalles

    Route::get('/taxes/definitive/again/{id}','CompanyTaxesController@againDefinitive')->name('taxes.again.definitive');//Calcular de nuevo

    Route::get('/taxes/definitive/payment/{id}','CompanyTaxesController@typePaymentDefinitive')->name('taxes.payment.definitive');//forma de pago de taxes

    Route::post('/taxes/definitive/payment/store','CompanyTaxesController@paymentDefinitiveStore')->name('taxes.payment.definitive.store');//forma de pago de taxes

    Route::get('taxes/definitive/pdf/{id}','CompanyTaxesController@definitivePDF')->name('taxes.definitive.pdf');

    //_______________________________________TICKOFFICE DEFINITIVE_____________________________________________________
    Route::get('tick-office/taxes/definitive/verify/{id}','TicketOfficeController@verifyDefinitive');








    Route::get('/payments/reconcile', function () {
        return view('modules.payments.register');
    })->name('payments.reconcile');

    Route::get('/payments/manage', function () {
        return view('modules.payments.manage');
    })->name('payments.manage');

    Route::get('/payments/register', function () {
        return view('modules.payments.create');
    })->name('payments.register');

    Route::get('/payments/details', function () {
        return view('modules.payments.details');
    })->name('payments.details');

    // ---------------------------------------------------------------
    Route::get('payments/receipt', 'PaymentsTaxesController@getPDF')->name('payments.receipt');

    Route::get('/bank/', function () {

        return view('dev.bank');
    });

    Route::post('/bank/import', 'BankController@import')->name('bank.import');
    Route::get('/bank/verify', 'BankController@verifyPayments');
    Route::get('/codigo-qr', function () {
        return view('dev.taxesQr');
    });

    Route::get('/cargar-ciu', function () {
        return view('modules.bank.upload');
    });

    // Payments Taxes Module

    Route::get('/paymentsTaxes-register/{id}', array(
        'as' => 'registerPayments',
        'uses' => 'PaymentsTaxesController@create'
    ));
    Route::get('paymentsTaxes/pdf/', 'PaymentsTaxesController@pdf');
    Route::post('paymentsTaxes/save', array(
        'as' => 'savePaymentsTaxes',
        'uses' => 'PaymentsTaxesController@store'
    ));

    Route::post('/update-paymentsTaxes/{id?}', array(
        'as' => 'updatePayments',
        'uses' => 'PaymentsTaxesController@edit'
    ));
    //References bank module

    Route::get('/referenceBank-register', function () {
        return view('modules.bank.upload');
    })->name('bank.upload');

    Route::post('/save-referenceBank', array(
        'as' => 'saveReferenceBank',
        'uses' => 'PaymentsImportController@importFile'
    ));

    Route::get('get-pdf/{pdf}', array(
        'as' => 'pdfImport',
        'uses' => 'PaymentsImportController@pdfImport'
    ));

    Route::get('/company/verify-rif/{rif}', 'CompaniesController@verifyRif');
    Route::get('/company/verify-license/{license}/{rif}', 'CompaniesController@verifyLicense');

    Route::get('/company/find/{rif}', 'CompaniesController@findCompany');


    Route::post('ciu/filter-group', 'CiuController@filterCiu');
    Route::get('/company/find/{rif}', 'CompaniesController@findCompany');
    //Fines module routes

    //Fines Company module routes
    Route::get('/fines/manage', function () {
        return view('modules.fines.menu');
    })->name('fines.manage');


    Route::get('/fines/register', function () {
        return view('modules.fines.register');
    })->name('fines.register');

    Route::post('/fines/save', 'FinesController@store')->name('fines.save');
    Route::get('/fines/read', 'FinesController@show')->name('fines.read');
    Route::get('/fines/details/{id}', 'FinesController@edit')->name('fines.details');
    Route::post('/fines/update/{id}', 'FinesController@update')->name('fines.update');
    Route::get('/fines/delete/{id}', 'FinesController@destroy')->name('fines.delete');

    // ------------------------ Fiscal
    Route::get('/fines-company/register/{id}', function () {
        return view('modules.fines-company.register');
    })->name('fines-company.register');
    Route::get('/read-fines-company', array(
        'as' => 'readFinesCompany',
        'uses' => 'FinesCompanyController@show'
    ));
    Route::get('fines-company/read', 'FinesCompanyController@read')->name('fines-company.read');
    Route::get('/fines-company/create/{id}', 'FinesCompanyController@create')->name('fines-company.create');
    Route::post('/fines-company/save', 'FinesCompanyController@store')->name('fines-company.save');
    Route::get('/fines-company/details/{id}', 'FinesCompanyController@edit')->name('fines-company.details');


    // Employees Modules

    Route::get('/employees-register', function () {
        return view('dev.employees.register');
    })->name('employees.employees-register');

    Route::post('/save-employees', array(
        'as' => 'saveEmployees',
        'uses' => 'EmployeesController@store'
    ));

    Route::get('/readEmployees', array(
        'as' => 'readEmployees',
        'uses' => 'EmployeesController@show'
    ));

    Route::get('estates/my-prperties', 'PropertyController@myProperty');

    Route::get('/ciu/find/{ciu} ', 'CiuController@findCiu');


    Route::get('/help', function () {
        return view('modules.helps.manage');
    })->name('helps.manage');
    Route::get('/help/register-company', function () {
        return view('modules.helps.register-company');
    })->name('help.register-company');

    Route::get('/taxes/payments', function () {
        return view('modules.taxes.payments');
    })->name('taxes.payments');

    Route::get('/pdfMultas', 'CompanyTaxesController@pdfMultas');
    Route::get('/taxes/payments', function () {
        return view('modules.taxes.payments');
    })->name('taxes.payments');


});
