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

Route::middleware(['auth'])->group(/**
 *
 */
    function () {


        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::get('/download/{file}', 'HomeController@downloadPdf')->name('download');

        // Usuarios
        Route::group(['middleware' => ['permission:Gestionar Usuarios']], function () {
            // Nivel 1: Gestionar Usuario
            Route::get('/users/manage', 'UserController@index')->name('users.manage');


            // Nivel 2: Registro y Consulta
            Route::group(['middleware' => ['permission:Registrar Usuario|Consultar Usuarios']], function () {
                Route::get('/users/register', 'UserController@create')->name('users.register');
                Route::post('/users/save', 'UserController@store')->name('users.save');
                Route::get('/users/read', 'UserController@show')->name('users.read');
                // Nivel 3: Detalles
                Route::group(['middleware' => ['permission:Detalles Usuarios']], function () {
                    Route::get('/users/details/{id}', 'UserController@edit')->name('users.details');
                    Route::get('/users/security/{id}', 'UserController@detailsSecurity')->name('users.security');


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

        ########## MODULO DE AYUDAS ############
        Route::get('/help', function () {
            return view('modules.helps.manage');
        })->name('helps.manage');
        Route::get('/help/register-company', function () {
            return view('modules.helps.register-company');
        })->name('help.register-company');
        ########################################


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
            Route::group(['middleware' => ['permission:Registrar Unidad Tribuaria|Consultar Unidades Tribuarias']], function () {
                Route::get('/tax-unit/register', function () {
                    return view('modules.tax-unit.register');
                })->name('tax-unit.register');
                Route::post('/tax-unit/save', 'TributoController@store')->name('tax-unit.save');
                Route::get('/tax-unit/read', 'TributoController@show')->name('tax-unit.read');
            });


            Route::group(['middleware' => ['permission:Registrar Grupo CIIU|Consultar Grupos CIIU|Gestionar Ramos CIIU']], function () {
                Route::get('/ciu-group/register', function () {
                    return view('modules.ciiu-group.register');
                })->name('ciu-group.register');
                Route::post('/ciu-group/save', 'groupCiiuController@store')->name('ciu-group.save');
                Route::get('/ciu-group/read', 'GroupCiiuController@show')->name('ciu-group.read');
                Route::get('/ciu-group/verify-code/{code}', 'GroupCiiuController@verifyGroupCiu');

                Route::get('/ciu-branch/manage', function () {
                    return view('modules.ciiu.menu');
                })->name('ciu-branch.manage');
                // Nivel 4 (Gestionar Ramo CIIU)


                Route::group(['middleware' => ['permission:Registrar Ramo CIIU|Consultar Ramos CIIU']], function () {
                    Route::get('/ciu-branch/register', 'CiuController@index')->name('ciu-branch.register');
                    Route::post('/ciu-branch/save', 'CiuController@create')->name('ciu-branch.save');
                    Route::get('/ciu-branch/read', 'CiuController@show')->name('ciu-branch.read');
                    Route::get('/ciu-branch/verify-code/{code}', 'CiuController@verifyCiu');


                    // Nivel 5 (Detalles)
                    Route::group(['middleware' => ['permission:Detalles Ramo CIIU|Actualizar Ramos CIIU']], function () {
                        Route::get('/ciu-branch/details/{id}', 'CiuController@edit')->name('ciu-branch.details');
                        Route::post('/ciu-branch/update', 'CiuController@update')->name('ciu-branch.update');
                        // Route::get('/ciu-branch/delete/{id}', 'CiuController@destroy')->name('ciu-branch.delete');
                    });
                });
            });

            // Gestionar Tipos de Vehiculos
            Route::group(['middleware' => ['permission:Gestionar Tipos de Vehiculos']], function () {
                Route::get('/vehicles/type-vehicles', function () {
                    return view('modules.vehicle_type.manage');
                })->name('vehicles.type.vehicles');
                # Nivel 1: Registrar o Consultar
                Route::group(['middleware' => ['permission:Registrar Tipo de Vehiculo|Consultar Tipos de Vehiculos']], function () {
                    Route::get('/vehicles/register-type', function () {
                        return view('modules.vehicle_type.register');
                    })->name('vehicles.type.register');
                    Route::post('/type-vehicles/save', 'VehicleTypeController@store')->name('typeVehicles.save');
                    Route::get('/type-vehicles/read', 'VehicleTypeController@show')->name('type-vehicles.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Tipo de Vehiculos']], function () {
                        Route::get('/type-vehicles/details/{id?}', 'VehicleTypeController@edit')->name('typeVehicle.details');
                        Route::post('/type-vehicles/update', 'VehicleTypeController@update')->name('typeVehicles.update');
                    });
                });
            });

            // Gestionar Tipos de Vehiculos
            Route::group(['middleware' => ['permission:Gestionar Tipos de Vehiculos']], function () {
                Route::get('/vehicles/type-vehicles', function () {
                    return view('modules.vehicle_type.manage');
                })->name('vehicles.type.vehicles');
                # Nivel 1: Registrar o Consultar
                Route::group(['middleware' => ['permission:Registrar Tipo de Vehiculo|Consultar Tipos de Vehiculos']], function () {
                    Route::get('/vehicles/register-type', function () {
                        return view('modules.vehicle_type.register');
                    })->name('vehicles.type.register');
                    Route::post('/type-vehicles/save', 'VehicleTypeController@store')->name('typeVehicles.save');
                    Route::get('/type-vehicles/read', 'VehicleTypeController@show')->name('type-vehicles.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Tipo de Vehiculos']], function () {
                        Route::get('/type-vehicles/details/{id?}', 'VehicleTypeController@edit')->name('typeVehicle.details');
                        Route::post('/type-vehicles/update', 'VehicleTypeController@update')->name('typeVehicles.update');
                    });
                });
            });

            // Gestionar Marcas de vehiculos
            Route::group(['middleware' => ['permission:Gestionar Marcas de Vehiculos']], function () {
                Route::get('/vehicles/brands-vehicles', function () {
                    return view('modules.vehicles_brand.manage');
                })->name('vehicles.brand.manage');
                Route::post('/vehicles-brand/verifyBrand', 'BrandVehicleController@verifyBrand')->name('vehicles.brand.verifyBrand');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Marca de Vehiculo|Consultar Marcas de Vehiculos']], function () {
                    Route::get('/vehicles-brand/register', 'BrandVehicleController@create')->name('vehicles.brand.register');
                    Route::post('/vehicles-brand/save', 'BrandVehicleController@store')->name('vehicles.brand.save');
                    Route::get('/vehicles-brand/read', 'BrandVehicleController@show')->name('vehicles.brand.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Marca de Vehiculos']], function () {
                        Route::get('/vehicles-brand/details/{id}', 'BrandVehicleController@edit')->name('vehicles.brand.details');
                        Route::post('/vehicles-brand/update', 'BrandVehicleController@update')->name('vehicles.brand.update');
                    });
                });
            });

            // Gestionar Modelos de Vehiculos
            Route::group(['middleware' => ['permission:Gestionar Modelos de Vehiculos']], function () {
                Route::get('/vehicles/models-vehicles', function () {
                    return view('modules.vehicles_models.manage');
                })->name('vehicles.models.vehicles');
                # nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Modelo de Vehiculo|Consultar Modelos de Vehiculos']], function () {
                    Route::get('/vehicles-models/register', 'ModelsVehicleController@create')->name('vehicles.models.register');
                    Route::post('/vehicles-models/save', 'ModelsVehicleController@store')->name('vehicles.register.save');
                    Route::get('/vehicles-models/read', 'ModelsVehicleController@show')->name('vehicles.models.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Modelo de Vehiculos']], function () {
                        Route::get('/vehicles-models/details/{id}', 'ModelsVehicleController@edit')->name('vehicles.models.details');
                        Route::post('/vehicles-models/update', 'ModelsVehicleController@update')->name('vehicles.models.update');
                    });
                });
            });

            // Gestionar Recargos
            Route::group(['middleware' => ['permission:Gestionar Recargos']], function () {
                Route::get('/recharges/manage', 'RechargeController@manage')->name('recharges.manage');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Recargo|Consultar Recargos']], function () {
                    Route::get('/recharges/register', 'RechargeController@create')->name('recharges.register');
                    Route::post('/recharges/save', 'RechargeController@store')->name('recharges.save');
                    Route::get('/recharges/read', 'RechargeController@show')->name('recharges.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Recargo']], function () {
                        Route::get('/recharges/details/{id}', 'RechargeController@details')->name('recharges.details');
                        Route::post('/recharges/update', 'RechargeController@update')->name('recharges.update');
                    });
                });
            });

            // Gestionar Accesorios
            Route::group(['middleware' => ['permission:Gestionar Accesorios']], function () {
                Route::get('accessories/manage', 'AccessoriesController@manage')->name('accessories.manage');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Accesorio|Consultar Accesorios']], function () {
                    Route::get('accessories/register', 'AccessoriesController@create')->name('accessories.register');
                    Route::post('accessories/save', 'AccessoriesController@store')->name('accessories.save');
                    Route::get('accessories/read', 'AccessoriesController@show')->name('accessories.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Accesorio']], function () {
                        Route::get('accessories/details/{id}', 'AccessoriesController@details')->name('accessories.details');
                        Route::post('accessories/update', 'AccessoriesController@update')->name('accessories.update');
                    });
                });
            });

            // Gestionar tipos de publicidad
            Route::group(['middleware' => ['permission:Gestionar Tipos de Publicidad']], function () {
                Route::get('advertising-type/manage', 'AdvertisingTypeController@manage')->name('advertising-type.manage');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Tipo de Publicidad|Consultar Tipos de Publicidad']], function () {
                    Route::get('advertising-type/register', 'AdvertisingTypeController@create')->name('advertising-type.register');
                    Route::post('advertising-type/save', 'AdvertisingTypeController@store')->name('advertising-type.save');
                    Route::get('advertising-type/read', 'AdvertisingTypeController@show')->name('advertising-type.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Tipo de Publicidad']], function () {
                        Route::get('advertising-type/details/{id}', 'AdvertisingTypeController@details')->name('advertising-type.details');
                        Route::post('advertising-type/update', 'AdvertisingTypeController@update')->name('advertising-type.update');
                    });
                });
            });

            // Gestionar Grupos de publicidad
            Route::group(['middleware' => ['permission:Gestionar Grupos de Publicidad']], function () {
                Route::get('group_publicity/manage', 'GroupPublicityController@index')->name('group-publicity.manage');
                Route::post('/group_publicity/verifyName', 'GroupPublicityController@verifyName')->name('group-publicity.verifyBrand');

                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Grupo de Publicidad|Consultar Grupos de Publicidad']], function() {
                    Route::get('group_publicity/register', 'GroupPublicityController@create')->name('group-publicity.register');
                    Route::post('group_publicity/save', 'GroupPublicityController@store')->name('group-publicity.save');
                    Route::get('group_publicity/read', 'GroupPublicityController@show')->name('group-publicity.read');
                    Route::group(['middleware' => ['permission:Detalles Grupo de Publicidad']], function() {
                        Route::get('group_publicity/details/{id}', 'GroupPublicityController@edit')->name('group-publicity.details');
                        Route::post('group_publicity/update', 'GroupPublicityController@update')->name('group-publicity.update');
                    });
                });
            });

            // Gestionar Tasas del Banco
            Route::group(['middleware' => ['permission:Gestionar Tasas del Banco']], function () {
                Route::get('bank-rate/manage', 'BankRateController@manage')->name('bank.rate.manage');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Tasa de Banco|Consultar Tasas del Banco']], function () {
                    Route::get('bank-rate/register', 'BankRateController@create')->name('bank.rate.register');
                    Route::post('bank-rate/save', 'BankRateController@store')->name('bank.rate.save');
                    Route::get('bank-rate/read', 'BankRateController@show')->name('bank.rate.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Tasa de Banco']], function () {
                        Route::get('bank-rate/details/{id}', 'BankRateController@details')->name('bank.rate.details');
                        Route::post('bank-rate/update', 'BankRateController@update')->name('bank.rate.update');
                    });
                });
            });

            // Gestionar Tasas
            Route::group(['middleware' => ['permission:Gestionar Tasas']], function () {
                Route::get('rate/manager', 'RateController@manager')->name('rate.manager');
                Route::get('rate/verify-code/{code}/{id?}', 'RateController@verifyCode');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Tasa|Consultar Tasas']], function () {
                    Route::get('rate/register', 'RateController@create')->name('rate.register');
                    Route::post('rate/save', 'RateController@store')->name('rate.save');
                    Route::get('rate', 'RateController@index')->name('rate.index');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Tasa']], function () {
                        Route::get('rate/details/{id}', 'RateController@details')->name('rate.details');
                        Route::post('rate/update', 'RateController@update');
                    });
                });
            });

            // GEstion de Alicuotas
            Route::group(['middleware' => ['permission:Gestionar Alicuotas']], function () {
                Route::get('/alicuota/manage', 'AlicuotaController@manage')->name('alicuota.manage');
                # Nivel 1: Registrar y Consultar
                Route::group(['middleware' => ['permission:Consultar Alicuotas']], function () {
                    Route::get('/alicuota/read', 'AlicuotaController@show')->name('alicuota.read');
                    # Nivel 2: Detalles
                    Route::group(['middleware' => ['permission:Detalles Alicuota']], function () {
                        Route::get('/alicuota/details/{id}', 'AlicuotaController@details')->name('alicuota.details');
                        Route::post('/alicuota/update', 'AlicuotaController@update')->name('alicuota.update');
                    });
                });
            });


            // Gestionar Valor Catastral - Construccion
            Route::group(['middleware' => ['permission:Gestionar Catastral Construccion']], function () {
                Route::get('/catastral-construction/manager', 'CatastralConstruccionController@manage')->name('catrastal.construction.manage');
                # Nivel 1 - Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Valor Construccion|Consultar Valores Construccion']], function () {
                    Route::get('/catastral-construction/register', 'CatastralConstruccionController@create')->name('catrastal.construction.register');
                    Route::post('/catastral-construction/save', 'CatastralConstruccionController@store')->name('catrastal.construction.save');
                    Route::get('/catastral-construction/read', 'CatastralConstruccionController@show')->name('catrastal.construction.read');
                    # Nivel 2 - Detalles
                    Route::group(['middleware' => ['permission:Detalles Valor Construccion']], function () {
                        Route::get('/catastral-construction/details/{id}', 'CatastralConstruccionController@details')->name('catrastal.construction.details');
                        Route::post('/catastral-construction/update', 'CatastralConstruccionController@update')->name('catrastal.construction.update');
                    });
                });
            });

            // Gestionar Valor Catastral - Terreno
            Route::group(['middleware' => ['permission:Gestionar Catastral Terreno']], function () {
                Route::get('/catastral-terreno/manager', 'CatastralTerrenoController@manage')->name('catrastal.terreno.manage');
                #Nivel 1 - Registrar y Consultar
                Route::group(['middleware' => ['permission:Registrar Valor Terreno|Consultar Valores Terreno']], function () {
                    Route::get('/catastral-terreno/register', 'CatastralTerrenoController@create')->name('catrastal.terreno.register');
                    Route::post('/catastral-terreno/save', 'CatastralTerrenoController@store')->name('catrastal.terreno.save');
                    Route::get('/catastral-terreno/read', 'CatastralTerrenoController@show')->name('catrastal.terreno.read');
                    # Nivel 2 - Detalles
                    Route::group(['middleware' => ['permission:Detalles Valor Terreno']], function () {
                        Route::get('/catastral-terreno/details/{id}', 'CatastralTerrenoController@details')->name('catrastal.terreno.details');
                        Route::post('/catastral-terreno/update', 'CatastralTerrenoController@update')->name('catrastal.terreno.update');
                    });
                });
            });

            // Gestionar Dias de Cobro
            Route::group(['middleware' => ['permission:Gestionar Dias de Cobro']], function () {
                Route::get('/prologue/manage', 'PrologueController@manage')->name('prologue.manage');
                #Nivel 1 - Registrar y Consultar
                Route::group(['middleware' => ['permission:Consultar Dias de Cobro']], function () {
                    Route::get('/prologue/index', 'PrologueController@index')->name('prologue.index');
                    # Nivel 2 - Detalles
                    Route::group(['middleware' => ['permission:Detalles Dia de Cobro']], function () {
                        Route::get('/prologue/details/{id}', 'PrologueController@details')->name('prologue.details');
                        Route::post('/prologue/update', 'PrologueController@update')->name('prologue.update');
                    });
                });
            });

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

        ######################### RUTAS QUE DEBEN SER GLOBALES
        ##### TASAS
        Route::get('rate/taxpayers/find/{type_document}/{document}', 'RateController@findTaxPayers');
        Route::get('rate/ticket-office/verify-email/{mail}', 'RateController@verifyEmail')->name('rate.ticketoffice.verify.email');
        Route::post('rate/taxpayers/company-user/register', 'RateController@registerCompanyUsers');
        Route::get('rate/taxpayers/pdf/{id}/{download?}', 'RateController@pdfTaxPayers')->name('rate.taxpayers.pdf');

        ##### VEHICULOS
        Route::post('/vehicles/searchBrand', 'VehicleController@brand')->name('vehicle.searchModel');
        Route::post('/vehicles/verifyLicense', 'VehicleController@licensePlate')->name('vehicle.licensePlate');
        Route::post('/vehicles/verifyBodySerial', 'VehicleController@bodySerial')->name('vehicle.bodySerial');
        Route::post('/vehicles/verifySerialEngine', 'VehicleController@serialEngine')->name('vehicle.serialEngine');
        Route::post('/taxes/credits_fiscal/vehicles', 'VehiclesTaxesController@creditsFiscal')->name('taxes.creditsFiscal.vehicle');
        Route::get('company/vehicles/{idCompany}', 'VehicleController@vehicleCompanyRead')->name('company.vehicle.read');
        Route::get('/vehicles/register/{register?}', 'VehicleController@create')->name('vehicles.register');
        Route::get('/vehicles/register/{register}', 'VehicleController@create')->name('vehicles.register');

        ##### INMUEBLES
        Route::post('/properties/taxes/total', 'PropertyTaxesController@calculateAmount');
        Route::post('properties/taxpayers/company-user/register', 'PropertyController@registerCompanyUsers');

        ##### EMPRESAS
        Route::get('company/ciu/{id_ciu}/{company_id}/{status}', 'CompaniesController@changeStatusCiiu');
        Route::post('company/update/map', 'CompaniesController@updatedMap');
        Route::get('/company/verify/{id}', 'CompaniesController@verifyTaxes');
        Route::post('/company/update', 'CompaniesController@update')->name('companies.update');
        Route::post('/company/addCiiu', 'CompaniesController@addCiiu')->name('companies.addCiiu');
        Route::get('/company/change-status/{id}/{status}', 'CompaniesController@changeStatus');
        Route::get('/company/change-users/{company_id}/{ci}', 'CompaniesController@changeUser');
        Route::get('/companies/my-payments/{company}', 'PaymentsController@menuPayments')->name('companies.my-payments');
        ##### PUBLICIDAD

        Route::get('property/find/{type_document}/{document}/{band}', 'PropertyController@findTaxPayers');
        Route::post('/publicity/save', 'PublicityController@store')->name('publicity.save');
        Route::post('/publicity/update', 'PublicityController@update')->name('publicity.update');

        // -------------------------------------------------------------
        // Mover esta ruta a la taquilla


        /* !NOTA!: HAY RUTAS QUE DEBEN IDENTIFICARSE PARA SABER A QUIEN PERTENECE, SI ES DE USUARIO WEB O DE TAQUILLA */

        ########################## -------------- USUARIO WEB -------------- #############################

        // --------------- ACTIVIDAD ECONOMICA ------------------------------------>
        Route::group(['middleware' => ['permission:Mis Empresas|Consultar Mis Empresas']], function () {
            Route::get('/payments/create/{company}/{type?}', 'CompanyTaxesController@create')->name('payments.create');
            Route::get('/payments/taxes/{id}', 'CompanyTaxesController@show');
            Route::get('/payments/calculate/{id}', 'CompanyTaxesController@calculate')->name('taxes.calculate');
            Route::get('/payments/taxes/download/{id}', 'CompanyTaxesController@downloadPDF')->name('taxes.download');


            // Nivel 1: Mis Empresas
            Route::get('/companies/my-business', 'CompaniesController@index')->name('companies.my-business');
            Route::get('/companies/details/{id}', 'CompaniesController@details')->name('companies.details');
            Route::get('/thumb/{filename}', 'CompaniesController@getImage')->name('companies.image');
            Route::get('/companies/carnet/{id}', 'CompaniesController@getCarnet')->name('companies.carnet');
            // Nivel 2: Registrar y Ver Detalles
            Route::group(['middleware' => ['permission:Registrar Mis Empresas']], function () {
                Route::get('/companies/register', 'CompaniesController@create')->name('companies.register');
                Route::post('/companies/save', 'CompaniesController@store')->name('companies.save');
            });
            // Nivel 3: Actualizar
            Route::group(['middleware' => ['permission:Detalles Mis Empresas']], function () {
                Route::get('/companies/edit/{id}', 'CompaniesController@edit')->name('companies.edit');
                ############################################################
                #### NOTA .................................................#
                ############################################################
                /* Arreglar Rutas Para declaracion de compañias */

            });
            Route::post('/payments/taxes', 'CompanyTaxesController@store')->name('taxes.save');
            Route::post('/payments/download/calculate', 'CompanyTaxesController@downloadCalculate')->name('taxes.calculate.download');
            Route::get('/payments/history/{company}', 'CompanyTaxesController@history')->name('payments.history');
            Route::post('/payments/register', 'CompanyTaxesController@payments')->name('payments.store');
            Route::post('/payments/taxes/save', 'CompanyTaxesController@taxesSave')->name('company.taxes.save');

            Route::post('/taxes/definitive/store', 'CompanyTaxesController@storeDefinitive')->name('taxes.save.definitive');//registro
            Route::get('/taxes/definitive/{id}', 'CompanyTaxesController@detailsDefinitive')->name('taxes.details.definitive');//detalles
            Route::get('/taxes/definitive/again/{id}', 'CompanyTaxesController@againDefinitive')->name('taxes.again.definitive');//Calcular de nuevo
            Route::get('/taxes/definitive/payment/{id}', 'CompanyTaxesController@typePaymentDefinitive')->name('taxes.payment.definitive');//forma de pago de taxes
            Route::post('/taxes/definitive/payment/store', 'CompanyTaxesController@paymentDefinitiveStore')->name('taxes.payment.definitive.store');//forma de pago de taxes
            Route::get('taxes/definitive/pdf/{id}', 'CompanyTaxesController@definitivePDF')->name('taxes.definitive.pdf');
        });


        // ---------------- MIS INMUEBLES ------------------------------------------------>
        Route::group(['middleware' => ['permission:Mis Inmuebles']], function () {
            Route::get('/properties/taxpayers/find/{type_document}/{document}', 'PropertyController@findTaxpayersCompany');
            Route::post('/properties/verification', 'PropertyController@verification')->name('properties.verification');
            Route::post('/properties/fractionalCalculation', 'PropertyTaxesController@fractionalCalculation');
            Route::post('/properties/discount', 'PropertyTaxesController@discount');
            Route::get('/properties/company/my-properties/{company_id}', 'PropertyController@readCompanyProperties')->name('properties.company.my-properties');

            # Nivel 1 - Registrar y Consultar
            Route::group(['middleware' => ['permission:Registrar Mis Inmuebles|Consultar Mis Inmuebles']], function () {
                Route::get('/properties/my-properties', 'PropertyController@index')->name('properties.my-properties');
                Route::get('/properties/register/{company_id?}', 'PropertyController@create')->name('properties.register');
                Route::post('/properties/save', 'PropertyController@store')->name('properties.save');
                # Nivel 2 - Detalles
                Route::group(['middleware' => ['permission:Detalles Mis Inmuebles']], function () {
                    Route::get('/properties/details/{id}', 'PropertyController@details')->name('properties.details');
                    # Nivel 3 - Declarar Inmueble
                    Route::group(['middleware' => ['permission:Mis Pagos - Inmuebles']], function () {
                        Route::get('/properties/payments/manage/{id}', 'PropertyTaxesController@manage')->name('properties.payments.manage');
                        # Nivel 4 - Declarar Inmueble & Historial de Pagos
                        Route::group(['middleware' => ['permission:Declarar Inmuebles|Historial de Pagos - Inmuebles']], function () {
                            Route::get('/properties/payments/create/{id}', 'PropertyTaxesController@create')->name('properties.payments.create');
                            Route::get('/properties/taxes/create/{id}/{status?}', 'PropertyTaxesController@create')->name('properties.taxes.create');
                            Route::post('/properties/taxes/store', 'PropertyTaxesController@store')->name('properties.taxes.store');
                            Route::get('/properties/payments/history/{id}', 'PropertyTaxesController@paymentHistoryTaxPayers')->name('properties.payments.history');
                            # ------
                            Route::get('/properties/taxes/payments/{id}', 'PropertyTaxesController@typePayment')->name('properties.taxes.payments');
                            # ------
                            # Nivel 5 - Pagar Inmueble
                            Route::group(['middleware' => ['permission:Pagar Inmueble']], function () {
                                Route::post('/properties/payments/store', 'PropertyTaxesController@paymentStore')->name('properties.payments.store');
                                Route::get('/properties/taxpayer/pdf/{id}/{download?}', 'PropertyTaxesController@pdfTaxpayer')->name('properties.taxpayers.pdf');
                            });
                        });
                    });
                });
            });
        });

        // ----------------- MIS TASAS ---------------------------------------------------------------->
        Route::group(['middleware' => ['permission:Generar Tasas']], function () {
            Route::get('rate/taxpayers/company/register/{id}', 'RateController@createRegisterCompany')->name('rate.taxpayers.company.create');
            Route::get('rate/taxpayers/menu', 'RateController@menuTaxPayers')->name('rate.taxpayers.menu');
            Route::get('rate/taxpayers/calculate/{id}', 'RateController@calculateTaxPayers')->name('rate.taxpayers.calculate');
            Route::get('rate/taxpayers/details/{id}', 'RateController@detailsTaxPayers')->name('rate.taxpayers.details');
            Route::get('rate/taxpayers/payments/{id}', 'RateController@typePaymentTaxPayers')->name('rate.taxpayers.typePayment');

            # Nivel 1 - Registrar y Consultar
            Route::group(['middleware' => ['permission:Declarar Tasas|Historial de Pagos - Tasas']], function () {
                Route::get('rate/taxpayers/register', 'RateController@registerTaxPayers')->name('rate.taxpayers.register');
                Route::post('rate/taxpayers/save', 'RateController@saveTaxPayers');
                Route::get('rate/taxpayers/payments-history', 'RateController@paymentHistoryTaxPayers')->name('rate.taxpayers.payment.history');
                Route::post('rate/taxpayers/payments/storage', 'RateController@paymentStoreTaxPayers')->name('rate.taxpayers.paymentStore');
            });
        });

        // -------------------- MIS VEHICULOS ------------------------------------------------------------>

        Route::group(['middleware' => ['permission:Mis Vehiculos']], function () {
            Route::get('/thumb/{filename}', 'VehicleController@getImage')->name('vehicles.image');
            Route::get('vehicle/findDocument/{typeDocument}/{document}', 'VehicleController@findTaxpayersCompany')->name('vehicle.documentFind');

            Route::post('/vehicles/update', 'VehicleTypeController@update')->name('typeVehicles.update');


            // Nivel 1: Registrar y Consultar
            Route::group(['middleware' => ['permission:Registrar Mis Vehiculos|Consultar Mis Vehiculos']], function () {
                Route::get('/vehicles/my-vehicles', 'VehicleController@show')->name('vehicles.my-vehicles');
                Route::get('/vehicles/read', 'VehicleController@show')->name('vehicles.read');
//                Route::get('/vehicles/register/{register}', 'VehicleController@create')->name('vehicles.register');
                Route::post('/vehicles/save', 'VehicleController@store')->name('Vehicles.save');
//                Route::post('/vehicles/save', 'VehicleController@store')->name('Vehicles.save');

                // Nivel 2: Detalles
                Route::group(['middleware' => ['permission:Detalles Mis Vehiculos']], function () {
                    Route::get('/vehicles/details/{id}', 'VehicleController@edit')->name('vehicles.details');
                    // Nivel 3 - Declara Vehiculos
                    Route::group(['middleware' => ['permission:Mis Pagos - Vehiculos']], function () {
                        Route::get('vehicles/manage/{id}', 'VehicleController@manage')->name('vehicles.manage');
                        # Nivel 4: Declarar y Ver Historial de pagos
                        Route::group(['middleware' => ['permission:Declarar Vehiculos|Historial de Pagos - Vehiculos']], function () {
                            Route::get('/taxes/vehicles/{id}', 'VehiclesTaxesController@create')->name('taxes.vehicle');
                            Route::post('/vehicle/taxes/save', 'VehiclesTaxesController@taxesSave')->name('vehicles.taxes.save');
                            Route::get('/vehicle/payments/history/{id}', 'VehiclesTaxesController@history')->name('vehicle.payments.history');
                            # Nivel 5: Pagar Vehiculo
                            Route::group(['middleware' => ['permission:Pagar Vehiculo']], function () {
                                Route::post('/vehicle/payments/register', 'VehiclesTaxesController@payments')->name('vehicle.payments.store');
                                Route::get('/vehicle/payments/taxes/download/{id}/{download}', 'VehiclesTaxesController@downloadPDF')->name('vehicle.taxes.download');
                            });
                        });
                    });

                });
            });

        });


        //Mi Publicidad
        Route::group(['middleware' => ['permission:Mis Publicidades|Consultar Mis Publicidades']], function () {
            // Nivel 1: Consultar y Registrar
            Route::get('/publicity/my-publicity', 'PublicityController@show')->name('publicity.my-publicity');
            Route::get('/publicity/company/my-publicity/{company_id}', 'PublicityController@readCompanyPublicities')->name('publicity.company.my-publicity');
            Route::get('/publicity/image/{filename}', 'PublicityController@getImage')->name('publicity.image');
            // Nivel 2: Registrar
            Route::group(['middleware' => ['permission:Registrar Mis Publicidades']], function () {
                Route::get('/publicity/register', 'PublicityController@create')->name('publicity.register');
                Route::get('/publicity/register/types/{company_id?}', 'PublicityController@chooseType')->name('publicity.register.types');
                Route::get('/publicity/register/create/{id}/{company_id?}', 'PublicityController@createByType')->name('publicity.register.create');
            });
            // Nivel 3: Detalles
            Route::group(['middleware' => ['permission:Detalles Mis Publicidades']], function () {
                Route::get('/publicity/details/{id}', 'PublicityController@details')->name('publicity.details');
                Route::get('/publicity/details/edit/{id}', 'PublicityController@edit')->name('publicity.edit');
            });

            // Declaraciones de Publicidad
            Route::get('/publicity/payments/manage/{id}', 'PublicityTaxesController@index')->name('publicity.payments.manage');
            Route::get('/publicity/payments/create/{id}', 'PublicityTaxesController@create')->name('publicity.payments.create');
            Route::post('/publicity/taxes/store', 'PublicityTaxesController@store')->name('publicity.taxes.store');
            Route::get('/publicity/payments/taxes/{id}', 'PublicityTaxesController@typePayment')->name('publicity.payments.taxes');
            Route::post('/publicity/payments/taxes/store', 'PublicityTaxesController@paymentStore')->name('publicity.payments.taxes.store');
            Route::get('/publicity/payments/history/{id}', 'PublicityTaxesController@paymentHistoryTaxPayers')->name('publicity.payments.history');
            Route::get('/publicity/taxpayer/pdf/{id}/{download?}', 'PublicityTaxesController@pdfTaxpayer')->name('publicity.taxpayers.pdf');


        });


        ############ CONTRIBUYENTE #######################
        Route::group(['middleware' => ['permission:Gestionar Contribuyentes']], function () {
            Route::get('/taxpayers/manage', function () {
                return view('modules.taxpayers.manage');
            })->name('taxpayers.manage');

            // Nivel 2: Registrar Y Consultar
            Route::group(['middleware' => ['permission:Registrar Contribuyente|Consultar Contribuyentes']], function () {
                Route::get('/taxpayers/register', function () {
                    return view('modules.taxpayers.register');
                })->name('taxpayers.register');
                Route::post('/taxpayers/save', 'UserController@storeTaxpayer')->name('taxpayers.save');
                Route::get('/taxpayers/read', 'UserController@showTaxpayer')->name('taxpayers.read');

                // Nivel 3: Detalles
                Route::group(['middleware' => ['permission:Detalles Contribuyentes']], function () {
                    Route::get('/taxpayers/details/{id}', 'UserController@detailsTaxpayer')->name('taxpayers.details');
                    Route::get('/taxpayers/details/company/{id}', 'UserController@detailsCompanyTaxPayers')->name('taxpayers.details.company');
                    Route::get('/taxpayers/details/rates/{id}', 'UserController@detailsRatesTaxPayers')->name('taxpayers.details.rates');
                    Route::get('/taxpayers/details/vehicle/{id}', 'UserController@detailsVehicleTaxPayers')->name('taxpayers.details.vehicle');
                    Route::get('/taxpayers/details/property/{id}', 'UserController@detailsPropertyTaxPayers')->name('taxpayers.details.property');

                    // Nivel 4: Actualizar, Resetear, Habilitar
                    Route::group(['middleware' => ['permission:Actualizar Contribuyentes|Habilitar/Deshabilitar Contribuyentes|Resetar Contribuyentes']], function () {
                        Route::post('/taxpayers/update/', 'UserController@updateTaxpayer')->name('taxpayers.update');
                        Route::post('/taxpayers/reset-password/', 'UserController@resetTaxpayerPassword')->name('taxpayers.reset-password');
                    });
                });
            });
        });


        ##################### ---------------- TAQUILLAS -------------------- ############################


        //___________________________________VEHICLE TICKET OFFICE ______________________________________________________________


        /*Route::post('ticketOffice/vehicle/save', 'TicketOfficeVehicleController@storeVehicle');
        Route::get('/ticketOffice/vehicle/read', 'VehicleController@showTicketOffice')->name('ticketOffice.vehicle.read');*/
//        Route::get('/ticketOffice/vehicle/details/{id}', 'TicketOfficeVehicleController@detailsVehicle')->name('ticketOffice.vehicle.details');


        //Route::get('/ticketOffice/vehicle/register',)->name('ticketOffice.vehicle.register');
        //Route::get('/ticketOffice/vehicle/register',)->name('ticketOffice.vehicle.register');
        //_______________________________________________________________________________________________________________________


        /*Route::post('ticketOffice/vehicle/save', 'TicketOfficeVehicleController@storeVehicle');
        Route::get('/ticketOffice/vehicle/read', 'VehicleController@showTicketOffice')->name('ticketOffice.vehicle.read');
        Route::get('/ticketOffice/vehicle/details/{id}', 'TicketOfficeVehicleController@detailsVehicle')->name('ticketOffice.vehicle.details');*/
        //Route::get('/ticketOffice/vehicle/register',)->name('ticketOffice.vehicle.register');


        Route::group(['middleware' => ['permission:Taquillas']], function () {
            Route::get('/ticketOffice/home', function () {
                return view('modules.ticket-office.homes');
            })->name('ticketOffice.home');
            ############# GLOBAL PARA TODAS LAS TAQUILLAS
            Route::post('/ticket-office/payment/save', 'TicketOfficeController@paymentTaxes');
            Route::get('/ticket-office/payments', 'TicketOfficeController@cashier')->name('ticket-office.payments');
            Route::get('/ticket-office/cashier/{id}', 'TicketOfficeController@QrTaxes');
            Route::get('ticketOffice/vehicle/cashier/{id}', 'TicketOfficeVehicleController@QrTaxes');
            Route::get('ticketOffice/property/cashier/{id}', 'PropertyTaxesController@QrTaxes');
            Route::get('ticketOffice/publicity/cashier/{id}', 'PublicityTaxesController@QrTaxes');



            Route::get('ticket-office/taxes/download/{id}', 'TicketOfficeController@viewPDF')->name('ticket-office.download.pdf');


            ###################### CAMBIAR STATUS DE PAGOS
            Route::get('/payments/change-status/{id}/{status}', 'TicketOfficeController@changeStatusPayment');
            Route::get('/ticket-office/my-payments/{type}', 'TicketOfficeController@myPaymentsTickOffice')->name('ticket-office.payment');
            Route::get('/ticket-office/find/code/{code}', 'TicketOfficeController@findCode');
            Route::get('/ticket-office/find/fiscal-period/{fiscal_period}/{company_id}', 'TicketOfficeController@verifyTaxes');
            Route::get('/ticket-office/find/user/{ci}', 'TicketOfficeController@findUser');
            Route::get('/ticket-office/pdf/taxes/{id}', 'TicketOfficeController@pdfTaxes');
            Route::get('/ticket-office/generate-receipt/{taxes}', 'TicketOfficeController@generateReceipt');
            Route::get('/ticket-office/taxes/calculate/{taxes_data}', 'TicketOfficeController@calculatePayments');
            Route::get('/ticket-office/payments/change/{id}/{status}', 'TicketOfficeController@changeStatustaxes');
            ##############################################


            ########### TAQUILLA --- ACTIVIDAD ECONOMICA
            Route::group(['middleware' => ['permission:Taquilla - Actividad Económica']], function () {
                Route::get('/home/ticketOffice', function () {
                    return view('modules.ticket-office.home');
                })->name('home.ticket-office');

                ############### DIFINITIVE TICKET OFFICE ####################
                Route::get('tick-office/taxes/definitive/verify/{id}', 'TicketOfficeController@verifyDefinitive');
                Route::post('ticket-office/taxes/definitive/save', 'TicketOfficeController@registerTaxeDefinitive');
                Route::get('ticket-office/taxes/definitive/{id}', 'TicketOfficeController@detailsTaxesDefinitive')->name('ticketoffice.details.definitive');

                # Nivel 1: Gestionar Empresa
                Route::group(['middleware' => ['permission:Gestionar Empresas']], function () {
                    Route::get('/companies/manage', function () {
                        return view('modules.companies.manage');
                    })->name('companies.manage');

                    // Nivel 2: Registrar y Consultar
                    Route::group(['middleware' => ['permission:Registrar Empresa|Consultar Empresas']], function () {
                        Route::get('ticketOffice/company/register', 'TicketOfficeController@registerCompany')->name('tickOffice.companies.register');
                        Route::post('ticketOffice/company/save', 'TicketOfficeController@storeCompany');
                        Route::get('ticketOffice/companies/all', 'TicketOfficeController@allCompanies')->name('companies.read');
                        // Nivel 3: Detalles
                        Route::group(['middleware' => ['permission:Detalles Empresas']], function () {
                            Route::get('ticketOffice/companies/details/{id}', 'TicketOfficeController@detailsCompany')->name('tickOffice.companies.details');
                            Route::get('ticketOffice/companies/details-taxes/{id}/{type}', 'TicketOfficeController@detailsCompanyTaxes')->name('tickOffice.companies.details-taxes');

                        });
                    });

                });
                # Nivel 1: Gestionar Pagos
                Route::group(['middleware' => ['permission:Gestionar Pagos - Actividad Económica']], function () {
                    Route::get('/ticket-office/taxes/', 'TicketOfficeController@getTaxes')->name('ticket-office.taxes.getTaxes');
                    Route::get('/ticket-office/taxes/ateco/details/{id}', 'TicketOfficeController@detailsTaxesAteco')->name('ticket-office.detailsTaxesAteco');
                    Route::get('/ticket-office/taxes/ateco/send-email/{id}', 'TicketOfficeController@sendEmailVerified');
                    Route::post('/ticket-office/taxes/save', 'TicketOfficeController@registerTaxes');

                    Route::get('/ticket-office/type-payment', function () {
                        return view('modules.payments.type_payment');
                    })->name('ticket-office.type.payments');
                });
            });

            ########### TAQUILLA --- VEHICULOS
            Route::group(['middleware' => ['permission:Taquilla - Vehiculos']], function () {
                Route::get('/ticketOffice/vehicle/home', function () {
                    return view('modules.ticket-office.vehicle.modules.home');
                })->name('ticketOffice.vehicle.home');
                Route::get('vehicle/change-user-web/{type}/{document}/{id}', 'TicketOfficeVehicleController@changeUserWeb')->name('vehicle.changeUserWeb');
                Route::get('vehicle/change-user/{type}/{document}/{id}', 'TicketOfficeVehicleController@changeUser')->name('vehicle.changeUser');
                Route::post('/ticketOffice/vehicle/status/', 'TicketOfficeVehicleController@statusVehicle')->name('ticketOffice.vehicle.status');
                Route::get('ticketOffice/vehicle/fiscal-period/{id}/{year}', 'TicketOfficeVehicleController@fiscalPeriod')->name('ticketOffice.vehicle.fiscalPeriod');
                Route::get('/ticketOffice/vehicle/search-license/{license}', 'VehicleController@searchLicensePlate')->name('ticketOffice.vehicle.searchLicense');
                Route::get('/ticketOffice/vehicle/period-fiscal/{period}', 'VehicleController@periodoFiscal')->name('ticketOffice.vehicle.periodFiscal');
                Route::get('ticketOffice/vehicle/viewDetails/{id}', 'TicketOfficeVehicleController@viewDetails')->name('ticketOffice.vehicle.viewDetails');


                # Nivel 1: Gestionar Vehiculos
                Route::group(['middleware' => ['permission:Gestionar Vehiculos']], function () {
                    Route::get('/ticketOffice/vehicle/manage', function () {
                        return view('modules.ticket-office.vehicle.modules.vehicle.home');
                    })->name('ticketOffice.vehicle.manage');

                    # Nivel 2: Registrar y Consultar
                    Route::group(['middleware' => ['permission:Registrar Vehiculo|Consultar Vehiculos']], function () {
                        Route::post('ticketOffice/vehicle/save', 'TicketOfficeVehicleController@storeVehicle');
                        Route::get('/ticketOffice/vehicle/read', 'VehicleController@showTicketOffice')->name('ticketOffice.vehicle.read');
                        # Nivel 3: Detalles
                        Route::group(['middleware' => ['permission:Detalles Vehiculos']], function () {
                            Route::get('/ticketOffice/vehicle/details/{id}', 'TicketOfficeVehicleController@detailsVehicle')->name('ticketOffice.vehicle.details');
                            Route::post('/ticketOffice/vehicle/update', 'VehicleController@update')->name('ticketOffice.vehicle.update');
                            Route::get('/ticketOffice/vehicle/history/{id}', 'TicketOfficeVehicleController@historyPayments')->name('ticketOffice.vehicle.history');
                        });
                    });
                });
                # Nivel 1: Gestionar Pagos
                Route::group(['middleware' => ['permission:Gestionar Pagos - Vehiculos']], function () {
                    Route::get('ticketOffice/vehicle/generatedPlanilla/{value}/{year}', 'TicketOfficeVehicleController@create')->name('ticketOffice.vehicle.generatedPlanilla');
                    Route::post('ticketOffice/vehicle/save-payroll', 'TicketOfficeVehicleController@taxesSave')->name('ticketOffice.vehicle.save-payroll');
                    Route::get('/ticketOffice/vehicle/generate-receipt/{taxes}', 'TicketOfficeVehicleController@generateReceipt');
                    Route::get('ticketOffice/vehicle/viewDetails/{id}', 'TicketOfficeVehicleController@viewDetails')->name('ticketOffice.vehicle.viewDetails');
                    Route::get('/ticketOffice/vehicle/taxes/', 'TicketOfficeVehicleController@getTaxes')->name('ticketOffice.vehicle.taxes.getTaxes');
                    Route::get('/ticketOffice/vehicle/payments/', function () {
                        return view('modules.ticket-office.vehicle.modules.payment.home');
                    })->name('ticketOffice.vehicle.payments');
                    Route::get('/ticketOffice/vehicle/payments/create', function () {
                        return view('modules.ticket-office.vehicle.modules.payment.create');
                    })->name('ticketOffice.vehicle.payments.create');
                });
            });


            ########### TAQUILLA --- TASAS
            Route::group(['middleware' => ['permission:Taquilla - Tasas']], function () {
                Route::get('rate/ticket-office/menu', 'RateController@menuTicketOffice')->name('rate.ticketoffice.menu');
                # Nivel 1: Generar Tasa y Ver los pagos de tasas
                Route::group(['middleware' => ['permission:Tasas - Generar Planilla|Tasas - Pagar Planillas']], function () {
                    Route::get('rate/ticket-office/generate', 'RateController@generateRateTicketOffice')->name('rate.ticketoffice.generate');
                    Route::post('rate/ticket-office/register', 'RateController@saveRateTicketOffice')->name('rate.ticketoffice.save');
                    Route::get('rate/ticket-office/generate-rate', 'RateController@generateRateTicketOffice')->name('rate.ticketoffice.generate');
                    Route::get('rate/ticket-office/payments', 'RateController@getTaxesRateTicketOffice')->name('rate.ticketoffice.payments');
                    # Nivel 2: Detalles de la Tasa
                    Route::group(['middleware' => ['permission:Tasas - Detalles Planilla']], function () {
                        Route::get('rate/ticket-office/details/{id}', 'RateController@detailsTicketOffice')->name('rate.ticketoffice.taxes.details');
                    });
                });

            });


            ########### TAQUILLA --- INMUEBLES
            Route::group(['middleware' => ['permission:Taquilla - Inmuebles']], function () {
                Route::get('property/ticket-office/home', 'PropertyController@homeTicketOffice')->name('property.ticket-office.home');
                Route::get('property/ticket-office/change-user/{property_id}/{ci}', 'PropertyController@changeUserPropertyTicketOffice');
                Route::get('property/ticket-office/change-propietario/{type}/{document}/{property_id}', 'PropertyController@changePropietarioPropertyTicketOffice');
                Route::post('property/ticket-office/update-map', 'PropertyController@updatedMapPropertyTicketOffice');
                Route::post('property/ticket-office/update-property', 'PropertyController@updatePropertyTicketOffice')->name('property.ticket-office.update-property');
                // ---------
                Route::get('/properties/ticket-office/manage', 'PropertyTaxesController@manageTicketOffice')->name('properties.ticket-office.manage');
//                Route::get('/properties/ticket-office/geneate', 'PropertyTaxesController@generateTicketOfficePayroll')->name('properties.ticket-office.generate');
                Route::get('/properties/ticket-office/geneate', 'PropertyTaxesController@generateTicketOfficePayroll')->name('properties.ticket-office.generate');
                Route::get('/properties/ticket-office/find/code/{code}', 'PropertyTaxesController@findCode')->name('properties.ticket-office.find');
                Route::get('/properties/ticket-office/taxes/{id}/{status?}/{fiscal_period}', 'PropertyTaxesController@taxesTicketOfficePayroll')->name('properties.ticket-office.store');
                Route::get('/properties/verify/fiscal-period/{id}/{year}', 'PropertyTaxesController@verifyFiscalPeriod')->name('properties.verify.fiscal-period');

                # Nivel 1: Gestionar Inmueble - Taquilla
                Route::group(['middleware' => ['permission:Gestionar Inmuebles']], function () {
                    Route::get('property/ticket-office/manager-property', 'PropertyController@managerPropertyTicketOffice')->name('property.ticket-office.manager-property');
                    # Nivel 2: Registrar y Consultar
                    Route::group(['middleware' => ['permission:Registrar Inmueble|Consultar Inmuebles']], function () {
                        Route::get('property/ticket-office/create-property', 'PropertyController@createPropertyTicketOffice')->name('property.ticket-office.create-property');
                        Route::post('property/ticket-office/save-property', 'PropertyController@savePropertyTicketOffice')->name('property.ticket-office.save-property');
                        Route::get('property/ticket-office/read-property', 'PropertyController@readPropertyTicketOffice')->name('property.ticket-office.read-property');
                        # Nivel 2: Detalles
                        Route::group(['middleware' => ['permission:Detalles Inmuebles']], function () {
                            Route::get('property/ticket-office/details-property/{id}', 'PropertyController@detailsPropertyTicketOffice')->name('property.ticket-office.details-property');
                            Route::post('property/ticket-office/update-property', 'PropertyController@updatePropertyTicketOffice')->name('property.ticket-office.update-property');
                            Route::get('/properties/ticket-office/property-taxes/{id}', 'PropertyController@allTaxes')->name('properties.ticket-office.property-taxes');
                        });
                    });
                });
                # Nivel 1: Gestionar Pagos de Inmuebles
                Route::group(['middleware' => ['permission:Gestionar Pagos - Inmuebles']], function () {
                    Route::get('/properties/ticket-office/manage', 'PropertyTaxesController@manageTicketOffice')->name('properties.ticket-office.manage');
                    Route::post('/properties/ticket-office/taxes/store', 'PropertyTaxesController@storeTicketOffice')->name('properties.ticket-office.taxes.store');
                    Route::get('/properties/ticket-office/payments/taxes', 'PropertyTaxesController@getTaxesTicketOffice')->name('properties.ticket-office.payments.taxes');
                    Route::get('/properties/ticket-office/payments/details/{id}/{status?}', 'PropertyTaxesController@detailsTicketOffice')->name('properties.ticket-office.payments.details');
                    Route::get('/properties/ticket-office/receipt/{id}/{download?}', 'PropertyTaxesController@generateReceipt')->name('properties.tickec-office.receipt');
                });
            });




//            Route::get('/ticketOffice/publicity/change-user-web/{type}/{document}/{id}', 'PublicityController@changeUserWeb')->name('ticketOffice.publicity.changeUserWeb');
            # ------------------------------------------------------------------- #


            ########### TAQUILLA --- PUBLICIDAD
            Route::group(['middleware' => ['permission:Taquilla - Publicidad']], function() {
                Route::get('/ticketOffice/publicity/home', function () {
                    return view('modules.publicity.ticket-office.home');
                })->name('ticketOffice.publicity.home');
                Route::get('/ticketOffice/publicity/getTypeGroup/{group}', 'PublicityController@searchGroup')->name('ticketOffice.publicity.getGroup');
                Route::get('/ticketOffice/publicity/change-user-web/{type}/{document}/{id}', 'PublicityController@changeUserWeb')->name('ticketOffice.publicity.changeUserWeb');
                Route::get('/ticketOffice/publicity/changeStatus/{id}/{status}','PublicityController@statusPublicity');
                Route::get('/ticketOffice/publicity/history/{id}', 'PublicityController@historyPayments')->name('ticketOffice.publicity.historyPayment');
                Route::get('/publicity/ticket-office/taxes/{id}/{status?}/{fiscal_period}', 'PublicityTaxesController@taxesTicketOfficePayroll')->name('publicity.ticket-office.store');
                Route::get('/publicity/ticket-office/find/code/{code}', 'PublicityTaxesController@findCode')->name('publicity.ticket-office.find.code');
                Route::get('/publicity/ticket-office/verify/fiscal-period/{id}/{year}', 'PublicityTaxesController@verifyFiscalPeriod')->name('publicity.ticket-office.verify.fiscal-period');


                // Nivel 1: Gestionar Publicidad
                Route::group(['middleware' => ['permission:Gestionar Publicidad']], function() {
                    Route::get('/ticketOffice/publicity/manage-publicity', function () {
                        return view('modules.publicity.ticket-office.menu');
                    })->name('ticketOffice.publicity.managePublicity');

                    // Nivel 2: Registrar y Consultar
                    Route::group(['middleware' => ['permission:Registrar Publicidad|Consultar Publicidad']], function () {
                        Route::get('/ticketOffice/publicity/register', function () {
                            return view('modules.publicity.ticket-office.register');
                        })->name('ticketOffice.publicity.register');
                        Route::get('/ticketOffice/publicity/show-Ticket-office', 'PublicityController@showTicketOffice')->name('ticketOffice.publicity.read');
                        Route::post('/ticketOffice/publicity/save', 'PublicityController@storeTicketOffice')->name('ticketOffice.publicity.save');

                        // Nivel 3: Detalles
                        Route::group(['middleware' => ['permission:Detalles Publicidad']], function() {
                            Route::get('/ticketOffice/publicity/details/{id}', 'PublicityController@detailsPublicity')->name('ticketOffice.publicity.detailsPublicity');
                        });
                    });
                });

                // Nivel 1: Gestionar Pagos
                Route::group(['middleware' => ['permission:Gestionar Pagos - Publicidad']], function() {
                    Route::get('/publicity/ticket-office/manage', 'PublicityTaxesController@manageTicketOffice')->name('publicity.ticket-office.manage');
                    Route::get('/publicity/ticket-office/generate', 'PublicityTaxesController@generateTicketOffice')->name('publicity.ticket-office.generate');
                    Route::post('/publicity/ticket-office/taxes/store', 'PublicityTaxesController@storeTicketOffice')->name('publicity.ticket-office.taxes.store');
                    Route::get('/publicity/ticket-office/payments/taxes', 'PublicityTaxesController@getTaxesTicketOffice')->name('publicity.ticket-office.payments.taxes');
                    Route::get('/publicity/ticket-office/receipt/{id}/{download?}', 'PublicityTaxesController@generateReceipt')->name('publicity.ticket-office.receipt');
                    Route::get('/publicity/ticket-office/payments/details/{id}/{status?}', 'PublicityTaxesController@detailsTicketOffice')->name('publicity.ticket-office.payments.details');
                });
            });

            ############ CONFIGURACION DE TAQUILLA

            Route::get('/ticket-office/config', 'TicketOfficeController@config')->name('ticket-office.config');

            ########### VERIFICACION DE PAGOS
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
                    Route::get('/bank/verified-today', 'VerifyPaymentsBankImportController@verifyPayments')->name('bank.read');
                    Route::get('/bank/verified-payments/full', 'VerifyPaymentsBankImportController@readPaymentsVerify')->name('bank.read.full');

                });
            });


            ########## LISTA DE PLANILLAS
            Route::get('/ticket-office/payment/web', 'TicketOfficeController@paymentsWeb')->name('ticket-office.pay.web');

            ########## VER PAGOS
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

        ########################################################################################################
        # NOTA: LAS SIGUIENTES RUTAS DESDE ESTE PUNTO SON DE MODULOS QUE ESTAN INCONPLETOS, QUE NO SE SABEN A
        # QUE MODULO PERTENECE O PARA QUE SIRVEN, SE QUEDAN PARA QUE EN NINGUN PUNTO DEL SISTEMA VAYA A REVENTAR.
        # SE CORREGIRAN CUANDO SE SEPA QUE HACEN, SE COMPLETE EL MODULO
        ########################################################################################################

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


        // Payments module routes

        Route::get('/payments/my-payments', function () {
            return view('modules.payments.menu');
        })->name('payments.my-payments');


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


        Route::get('/pdfMultas', 'CompanyTaxesController@pdfMultas');
        Route::get('/taxes/payments', function () {
            return view('modules.taxes.payments');
        })->name('taxes.payments');


        /*taxpayers company*/


        Route::get('test/{code}/{date_limit}', 'VerifyPaymentsBankImportController@verifyPaymentsTaxes');


        Route::get('home/test','HomeController@test');
    });