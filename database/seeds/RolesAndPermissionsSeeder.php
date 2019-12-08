<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Restablecer roles y permisos en caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Seguridad
        Permission::create(['name' => 'Seguridad']);

        // -- Bitacora
        Permission::create(['name' => 'Bitacora']);


        // Roles y Permisos
        Permission::create(['name' => 'Gestionar Roles y Permisos']);
        Permission::create(['name' => 'Crear Rol']);
        Permission::create(['name' => 'Ver Roles']);
        Permission::create(['name' => 'Actualizar Roles']);
        Permission::create(['name' => 'Detalles Roles']);
        // Permission::create(['name' => 'Eliminar Roles']);

        /**
         * Permisos Precargardos
         */


        // -- Gestionar Usuarios
        Permission::create(['name' => 'Gestionar Usuarios']);
        Permission::create(['name' => 'Registar Usuario']);
        Permission::create(['name' => 'Consultar Usuarios']);
        Permission::create(['name' => 'Detalles Usuarios']);
        Permission::create(['name' => 'Actualizar Usuarios']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Usuarios']);
        // Permission::create(['name' => 'Eliminar Usuarios']);
        Permission::create(['name' => 'Resetar Usuarios']);

        // Configuración
        Permission::create(['name' => 'Configuración']);

        // -- Gestionar Unidad Trubutaria
        Permission::create(['name' => 'Gestionar Unidad Tribuaria']);
        Permission::create(['name' => 'Registar Unidad Tribuaria']);
        Permission::create(['name' => 'Consultar Unidades Tribuarias']);

		// -- Gestionar CIIU
        Permission::create(['name' => 'Gestionar CIIU']);
        Permission::create(['name' => 'Registar Grupo CIIU']);
        Permission::create(['name' => 'Consultar Grupos CIIU']);
        // --  -- Gestionar Ramo CIIU
        Permission::create(['name' => 'Gestionar Ramos CIIU']);
		Permission::create(['name' => 'Registar Ramo CIIU']);
        Permission::create(['name' => 'Consultar Ramos CIIU']);
        Permission::create(['name' => 'Detalles Ramo CIIU']);
        Permission::create(['name' => 'Actualizar Ramos CIIU']);

        // Inmuebles

        // Vehículos

        // Publicidad




        // Taquilla
        Permission::create(['name' => 'Taquilla']);


        // -- Gestionar Contribuyente 
        Permission::create(['name' => 'Gestionar Contribuyentes']);
        Permission::create(['name' => 'Registar Contribuyente']);
        Permission::create(['name' => 'Consultar Contribuyentes']);
        Permission::create(['name' => 'Detalles Contribuyentes']);
        Permission::create(['name' => 'Actualizar Contribuyentes']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Contribuyentes']);
        // Permission::create(['name' => 'Eliminar Contribuyentes']);
        Permission::create(['name' => 'Resetar Contribuyentes']);


        // -- Gestionar Pagos (Taquillero)
        Permission::create(['name' => 'Gestionar Pagos']);
        Permission::create(['name' => 'Registrar Pago']);
        Permission::create(['name' => 'Ver Pagos']);
        Permission::create(['name' => 'Detalles Pagos']);
        Permission::create(['name' => 'Anular Pagos']);
        Permission::create(['name' => 'Verificar Pagos - Manual']);
        Permission::create(['name' => 'Verificar Pagos - Archivo']);
        Permission::create(['name' => 'Generar Planilla']);
        Permission::create(['name' => 'Pagar Planilla']);
        Permission::create(['name' => 'Ver Planillas']);
        Permission::create(['name' => 'Ver Planillas - Web']);
        Permission::create(['name' => 'Ver Planillas - Transferencia']);
        Permission::create(['name' => 'Ver Planillas - Taquilla']);
        Permission::create(['name' => 'Ver Pagos verificados']);


        // -- Gestionar Empresas
        Permission::create(['name' => 'Gestionar Empresas']);
        Permission::create(['name' => 'Registar Empresa']);
        Permission::create(['name' => 'Consultar Empresas']);
        Permission::create(['name' => 'Detalles Empresas']);
        Permission::create(['name' => 'Actualizar Empresas']);
        // Permission::create(['name' => 'Eliminar Empresas']);
        Permission::create(['name' => 'Añadir CIIU Empresas']);
        Permission::create(['name' => 'Eliminar CIIU Empresas']);
        Permission::create(['name' => 'Habilitar/Deshabilitar CIIU Empresas']);
        Permission::create(['name' => 'Historial de Pago Empresas']);

        // -- Gestionar Inmuebles
        Permission::create(['name' => 'Gestionar Inmuebles']);
        Permission::create(['name' => 'Registar Inmueble']);
        Permission::create(['name' => 'Consultar Inmuebles']);
        Permission::create(['name' => 'Detalles Inmuebles']);
        Permission::create(['name' => 'Actualizar Inmuebles']);
        // Permission::create(['name' => 'Eliminar Inmuebles']);

        // -- Gestionar Vehiculos
        Permission::create(['name' => 'Gestionar Vehiculos']);
        Permission::create(['name' => 'Registar Vehiculo']);
        Permission::create(['name' => 'Consultar Vehiculos']);
        Permission::create(['name' => 'Detalles Vehiculos']);
        Permission::create(['name' => 'Actualizar Vehiculos']);
        // Permission::create(['name' => 'Eliminar Vehiculos']);

        // GeoSEMAT

        Permission::create(['name' => 'GeoSEMAT']);

        // Estadisticas
        Permission::create(['name' => 'Estadisticas']);

        // Notificaciones
        Permission::create(['name' => 'Notificaciones']);
        Permission::create(['name' => 'Registrar Notificaciones']);
        Permission::create(['name' => 'Consultar Notificaciones']);
        Permission::create(['name' => 'Ver Notificaciones']);

        // Mis Gestiones
        // Mis Empresas
        Permission::create(['name' => 'Mis Empresas']);
        Permission::create(['name' => 'Registar Mis Empresas']);
        Permission::create(['name' => 'Consultar Mis Empresas']);
        Permission::create(['name' => 'Detalles Mis Empresas']);
        Permission::create(['name' => 'Actualizar Mis Empresas']);
        // Permission::create(['name' => 'Eliminar Mis Empresas']);


        // Mis Inmuebles
        Permission::create(['name' => 'Mis Inmuebles']);
        Permission::create(['name' => 'Registar Mis Inmuebles']);
        Permission::create(['name' => 'Consultar Mis Inmuebles']);
        Permission::create(['name' => 'Detalles Mis Inmuebles']);
        Permission::create(['name' => 'Actualizar Mis Inmuebles']);
        // Permission::create(['name' => 'Eliminar Mis Inmuebles']);

        Permission::create(['name' => 'Mis Vehiculos']);
        Permission::create(['name' => 'Registar Mis Vehiculos']);
        Permission::create(['name' => 'Consultar Mis Vehiculos']);
        Permission::create(['name' => 'Detalles Mis Vehiculos']);
        Permission::create(['name' => 'Actualizar Mis Vehiculos']);
        // Permission::create(['name' => 'Eliminar Mis Vehiculos']);

        // Mis Pagos - Empresas
        // Mis Empresas
        Permission::create(['name' => 'Mis Pagos - Actividad Económica']);
        Permission::create(['name' => 'Declarar Actividad Económica']);
        Permission::create(['name' => 'Ver Declaraciones - Actividad Económica']);

        Permission::create(['name' => 'Mis Pagos - Inmuebles']);
        Permission::create(['name' => 'Declarar Inmuebles']);
        Permission::create(['name' => 'Ver Declaraciones - Inmuebles']);


        Permission::create(['name' => 'Mis Pagos - Vehiculos']);
        Permission::create(['name' => 'Declarar Vehiculos']);
        Permission::create(['name' => 'Ver Declaraciones - Vehiculos']);

        //Creamos el Rol del superUsuario
        $roleSuperUser = Role::create(['name' => 'SuperUsuario']);
        //Asignamos todos los permisos
        $roleSuperUser->givePermissionTo(Permission::all());

        // Taquillero
        $roleTicketOfficer = Role::create(['name' => 'Taquillero']);
        $roleTicketOfficer->givePermissionTo([
            'Taquilla',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Habilitar/Deshabilitar Contribuyentes',
            'Resetar Contribuyentes',
            'Gestionar Pagos',
            'Registrar Pago',
            'Ver Pagos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Generar Planilla',
            'Pagar Planilla',
            'Ver Planillas',
            'Ver Planillas - Web',
            'Ver Planillas - Transferencia',
            'Ver Planillas - Taquilla',
            'Ver Pagos verificados',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago Empresas',
            'Gestionar Inmuebles',
            'Registar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Gestionar Vehiculos',
            'Registar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos'
        ]);

        // Contribuyente
        $roleTaxpayer = Role::create(['name' => 'Contribuyente']);
        $roleTaxpayer->givePermissionTo([
            'Mis Empresas','Registar Mis Empresas','Consultar Mis Empresas','Detalles Mis Empresas',
            'Actualizar Mis Empresas',
            'Mis Inmuebles',
            'Registar Mis Inmuebles',
            'Consultar Mis Inmuebles',
            'Detalles Mis Inmuebles',
            'Actualizar Mis Inmuebles',
            'Mis Vehiculos',
            'Registar Mis Vehiculos',
            'Consultar Mis Vehiculos',
            'Detalles Mis Vehiculos',
            'Actualizar Mis Vehiculos',
            'Mis Pagos - Actividad Económica',
            'Declarar Actividad Económica',
            'Ver Declaraciones - Actividad Económica',
            'Mis Pagos - Inmuebles',
            'Declarar Inmuebles',
            'Ver Declaraciones - Inmuebles',
            'Mis Pagos - Vehiculos',
            'Declarar Vehiculos',
            'Ver Declaraciones - Vehiculos'
        ]);

        DB::table('model_has_roles')->insert([
        	'role_id' => 1,
        	'model_type' => 'App\User',
        	'model_id' => 1
        ]);
        DB::table('model_has_roles')->insert([
        	'role_id' => 2,
        	'model_type' => 'App\User',
        	'model_id' => 2
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\User',
            'model_id' => 3
        ]);

    }	
}
