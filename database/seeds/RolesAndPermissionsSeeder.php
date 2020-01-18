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

        // -- Gestionar Usuarios
        Permission::create(['name' => 'Gestionar Usuarios']);
        Permission::create(['name' => 'Registar Usuario']);
        Permission::create(['name' => 'Consultar Usuarios']);
        Permission::create(['name' => 'Detalles Usuarios']);
        Permission::create(['name' => 'Actualizar Usuarios']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Usuarios']);
        // Permission::create(['name' => 'Eliminar Usuarios']);
        Permission::create(['name' => 'Resetear Usuarios']);
        Permission::create(['name' => 'Mi Perfil']);

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
        Permission::create(['name' => 'Taquillas']);
        Permission::create(['name' => 'Taquilla - Actividad Económica']);
        // Permission::create(['name' => 'Taquilla - Inmuebles']);
        // Permission::create(['name' => 'Taquilla - Vehículos']);
        // Permission::create(['name' => 'Taquilla - Publicidad']);

        // -- Gestionar Contribuyente 
        Permission::create(['name' => 'Gestionar Contribuyentes']);
        Permission::create(['name' => 'Registar Contribuyente']);
        Permission::create(['name' => 'Consultar Contribuyentes']);
        Permission::create(['name' => 'Detalles Contribuyentes']);
        Permission::create(['name' => 'Actualizar Contribuyentes']);
        // Permission::create(['name' => 'Eliminar Contribuyentes']);
        Permission::create(['name' => 'Resetear Contribuyentes']);

        // -- Gestionar Pagos (Taquillero)
        Permission::create(['name' => 'Gestionar Pagos']);
        Permission::create(['name' => 'Registrar Pago']);
        Permission::create(['name' => 'Registrar Pago - Transferencias']);
        Permission::create(['name' => 'Registrar Pago - Punto de Venta']);
        Permission::create(['name' => 'Registrar Pago - Depositos']);
        Permission::create(['name' => 'Detalles Pagos']);
        Permission::create(['name' => 'Anular Pagos']);
        Permission::create(['name' => 'Verificar Pagos - Manual']);
        Permission::create(['name' => 'Verificar Pagos - Archivo']);
        Permission::create(['name' => 'Cargar Archivo Pagos']);
        Permission::create(['name' => 'Ver Pagos verificados']);
        Permission::create(['name' => 'Generar Planilla']);
        Permission::create(['name' => 'Detalles Planilla']);
        Permission::create(['name' => 'Pagar Planilla']);
        Permission::create(['name' => 'Ver Pagos']);
        Permission::create(['name' => 'Ver Pagos - Transferencias']);
        Permission::create(['name' => 'Ver Pagos - Punto de Venta']);
        Permission::create(['name' => 'Ver Pagos - Depositos']);
        Permission::create(['name' => 'Mi Taquilla - Punto de Venta']);
        Permission::create(['name' => 'Mi Taquilla - Deposito']);
        Permission::create(['name' => 'Ver Planillas - Taquilla']);
        Permission::create(['name' => 'Escanear QR']);
        Permission::create(['name' => 'Taquilla - Caja']);
        Permission::create(['name' => 'Abrir/Cerrar Caja']);
        Permission::create(['name' => 'Ver Planillas']);

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
        Permission::create(['name' => 'Habilitar/Deshabilitar Empresas']);
        Permission::create(['name' => 'Cambiar Ubicacion - Empresa']);
        Permission::create(['name' => 'Cambiar Usuario - Empresa']);
        Permission::create(['name' => 'Historial de Pago - Empresas']);

        // -- Gestionar Inmuebles
        Permission::create(['name' => 'Gestionar Inmuebles']);
        Permission::create(['name' => 'Registar Inmueble']);
        Permission::create(['name' => 'Consultar Inmuebles']);
        Permission::create(['name' => 'Detalles Inmuebles']);
        Permission::create(['name' => 'Actualizar Inmuebles']);
        // Permission::create(['name' => 'Eliminar Inmuebles']);
        Permission::create(['name' => 'Historial de Pago - Inmuebles']);


        // -- Gestionar Vehiculos
        Permission::create(['name' => 'Gestionar Vehiculos']);
        Permission::create(['name' => 'Registar Vehiculo']);
        Permission::create(['name' => 'Consultar Vehiculos']);
        Permission::create(['name' => 'Detalles Vehiculos']);
        Permission::create(['name' => 'Actualizar Vehiculos']);
        // Permission::create(['name' => 'Eliminar Vehiculos']);
        Permission::create(['name' => 'Historial de Pago - Vehiculos']);

        // -- Gestionar Tipos de Vehiculos
        Permission::create(['name' => 'Gestionar Tipos de Vehiculos']);
        Permission::create(['name' => 'Registar Tipo de Vehiculo']);
        Permission::create(['name' => 'Consultar Tipos de Vehiculos']);
        Permission::create(['name' => 'Detalles Tipo de Vehiculos']);
        Permission::create(['name' => 'Actualizar Tipos de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Tipos de Vehiculos']);


        // -- Gestionar Modelos de Vehiculos
        Permission::create(['name' => 'Gestionar Modelos de Vehiculos']);
        Permission::create(['name' => 'Registar Modelo de Vehiculo']);
        Permission::create(['name' => 'Consultar Modelos de Vehiculos']);
        Permission::create(['name' => 'Detalles Modelo de Vehiculos']);
        Permission::create(['name' => 'Actualizar Modelos de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Modelos de Vehiculos']);


        // -- Gestionar Marcas de Vehiculos
        Permission::create(['name' => 'Gestionar Marcas de Vehiculos']);
        Permission::create(['name' => 'Registar Marca de Vehiculo']);
        Permission::create(['name' => 'Consultar Marcas de Vehiculos']);
        Permission::create(['name' => 'Detalles Marca de Vehiculos']);
        Permission::create(['name' => 'Actualizar Marcas de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Marcas de Vehiculos']);

        // -- Gestionar Recargos
        Permission::create(['name' => 'Gestionar Recargos']);
        Permission::create(['name' => 'Registar Recargo']);
        Permission::create(['name' => 'Consultar Recargos']);
        Permission::create(['name' => 'Detalles Recargo']);
        Permission::create(['name' => 'Actualizar Recargos']);
        // Permission::create(['name' => 'Eliminar Recargos']);

        // -- Gestionar Accessorios
        Permission::create(['name' => 'Gestionar Accesorios']);
        Permission::create(['name' => 'Registar Accesorio']);
        Permission::create(['name' => 'Consultar Accesorios']);
        Permission::create(['name' => 'Detalles Accesorio']);
        Permission::create(['name' => 'Actualizar Accesorios']);
        // Permission::create(['name' => 'Eliminar Accesorios']);

        // -- Gestionar Tipos de Publicidad
        Permission::create(['name' => 'Gestionar Tipos de Publicidad']);
        Permission::create(['name' => 'Registar Tipo de Publicidad']);
        Permission::create(['name' => 'Consultar Tipos de Publicidad']);
        Permission::create(['name' => 'Detalles Tipo de Publicidad']);
        Permission::create(['name' => 'Actualizar Tipos de Publicidad']);
        // Permission::create(['name' => 'Eliminar Tipos de Publicidad']);

        // GeoSEMAT

        Permission::create(['name' => 'GeoSEMAT']);

        // Estadisticas
        Permission::create(['name' => 'Estadisticas']);
        Permission::create(['name' => 'Estadisticas - SuperUsuario']);


        // Notificaciones
        Permission::create(['name' => 'Notificaciones']);
        Permission::create(['name' => 'Registrar Notificaciones']);
        Permission::create(['name' => 'Consultar Notificaciones']);
        Permission::create(['name' => 'Ver Notificaciones']);

        // Mis Gestiones ------------------------------------------------------------------
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

        // Mis vehiculos
        Permission::create(['name' => 'Mis Vehiculos']);
        Permission::create(['name' => 'Registar Mis Vehiculos']);
        Permission::create(['name' => 'Consultar Mis Vehiculos']);
        Permission::create(['name' => 'Detalles Mis Vehiculos']);
        Permission::create(['name' => 'Actualizar Mis Vehiculos']);
        // Permission::create(['name' => 'Eliminar Mis Vehiculos']);




        // Mis Publicidades
        Permission::create(['name' => 'Mis Publicidades']);
        Permission::create(['name' => 'Registar Mis Publicidades']);
        Permission::create(['name' => 'Consultar Mis Publicidades']);
        Permission::create(['name' => 'Detalles Mis Publicidades']);
        Permission::create(['name' => 'Actualizar Mis Publicidades']);
        // Permission::create(['name' => 'Eliminar Mis Publicidades']);


        // Mis Pagos - Empresas
        // Mis Empresas
        Permission::create(['name' => 'Mis Pagos - Actividad Económica']);
        Permission::create(['name' => 'Declarar Actividad Económica']);
        Permission::create(['name' => 'Declaración Anticipada - Actividad Económica']);
        Permission::create(['name' => 'Declaración Definitiva - Actividad Económica']);
        Permission::create(['name' => 'Historial de Pagos - Actividad Económica']);

        Permission::create(['name' => 'Mis Pagos - Inmuebles']);
        Permission::create(['name' => 'Declarar Inmuebles']);
        Permission::create(['name' => 'Historial de Pagos - Inmuebles']);


        Permission::create(['name' => 'Mis Pagos - Vehiculos']);
        Permission::create(['name' => 'Declarar Vehiculos']);
        Permission::create(['name' => 'Historial de Pagos - Vehiculos']);

        Permission::create(['name' => 'Mis Pagos - Publicidad']);
        Permission::create(['name' => 'Declarar Publicidades']);
        Permission::create(['name' => 'Historial de Pagos - Publicidades']);

        //Creamos el Rol del superUsuario
        $roleSuperUser = Role::create(['name' => 'SuperUsuario']);
        //Asignamos todos los permisos
        $roleSuperUser->givePermissionTo([
            'Seguridad',
            'Bitacora',
            'Gestionar Roles y Permisos',
            'Crear Rol',
            'Ver Roles',
            'Actualizar Roles',
            'Detalles Roles',
            'Gestionar Usuarios',
            'Registar Usuario',
            'Consultar Usuarios',
            'Detalles Usuarios',
            'Actualizar Usuarios',
            'Habilitar/Deshabilitar Usuarios',
            'Resetear Usuarios',
            'Configuración',
            'Gestionar Unidad Tribuaria',
            'Registar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registar Ramo CIIU',
            'Consultar Ramos CIIU',
            'Detalles Ramo CIIU',
            'Actualizar Ramos CIIU',
            'Gestionar Tipos de Vehiculos',
            'Registar Tipo de Vehiculo',
            'Consultar Tipos de Vehiculos',
            'Detalles Tipo de Vehiculos',
            'Actualizar Tipos de Vehiculos',
            'Gestionar Modelos de Vehiculos',
            'Registar Modelo de Vehiculo',
            'Consultar Modelos de Vehiculos',
            'Detalles Modelo de Vehiculos',
            'Actualizar Modelos de Vehiculos',
            'Gestionar Marcas de Vehiculos',
            'Registar Marca de Vehiculo',
            'Consultar Marcas de Vehiculos',
            'Detalles Marca de Vehiculos',
            'Actualizar Marcas de Vehiculos',
            'Gestionar Recargos',
            'Registar Recargo',
            'Consultar Recargos',
            'Detalles Recargo',
            'Actualizar Recargos',
            'Gestionar Accesorios',
            'Registar Accesorio',
            'Consultar Accesorios',
            'Detalles Accesorio',
            'Actualizar Accesorios',
            'Gestionar Tipos de Publicidad',
            'Registar Tipo de Publicidad',
            'Consultar Tipos de Publicidad',
            'Detalles Tipo de Publicidad',
            'Actualizar Tipos de Publicidad',
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Pagos',
            'Registrar Pago',
            'Registrar Pago - Transferencias',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Cargar Archivo Pagos',
            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
            'Ver Pagos - Transferencias',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
            'Ver Planillas',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Habilitar/Deshabilitar Empresas',
            'Cambiar Ubicacion - Empresa',
            'Cambiar Usuario - Empresa',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Gestionar Vehiculos',
            'Registar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'GeoSEMAT',
            'Estadisticas',
            'Estadisticas - SuperUsuario',
            'Notificaciones',
            'Registrar Notificaciones',
            'Consultar Notificaciones',
            'Ver Notificaciones',
            'Mi Perfil'
        ]);

        // Operador
        $roleTicketOfficer = Role::create(['name' => 'Operador']);
        $roleTicketOfficer->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            // 'Gestionar Pagos',
            // 'Generar Planilla',
            // 'Pagar Planilla',
            // 'Registrar Pago',
            // 'Registrar Pago - Punto de Venta',
            // 'Registrar Pago - Depositos',
            // 'Ver Pagos',
            // 'Mi Taquilla - Punto de Venta',
            // 'Mi Taquilla - Deposito',
            // 'Ver Planillas',
            // 'Ver Planillas - Taquilla',
            // 'Mi Perfil',
            // 'Gestionar Empresas',
            // 'Registar Empresa',
            // 'Consultar Empresas',
            // 'Detalles Empresas',
            // 'Taquilla - Caja',
            // 'Abrir/Cerrar Caja'
        ]);

        // Contribuyente
        $roleTaxpayer = Role::create(['name' => 'Contribuyente']);
        $roleTaxpayer->givePermissionTo([
            'Mis Empresas',
            'Registar Mis Empresas',
            'Consultar Mis Empresas',
            'Detalles Mis Empresas',
            // 'Actualizar Mis Empresas',
             'Mis Inmuebles',
             'Registar Mis Inmuebles',
             'Consultar Mis Inmuebles',
             'Detalles Mis Inmuebles',
            //'Actualizar Mis Inmuebles',
            'Mis Vehiculos',
            'Registar Mis Vehiculos',
            'Consultar Mis Vehiculos',
            'Detalles Mis Vehiculos',
            // 'Actualizar Mis Vehiculos',
            // 'Mis Pagos - Actividad Económica',
            // 'Declarar Actividad Económica',
            // 'Declaración Anticipada - Actividad Económica',
            // 'Declaración Definitiva - Actividad Económica',
            // 'Historial de Pagos - Actividad Económica',
            // 'Mis Pagos - Inmuebles',
            // 'Declarar Inmuebles',
            // 'Ver Declaraciones - Inmuebles',
            // 'Mis Pagos - Vehiculos',
            // 'Declarar Vehiculos',
            // 'Ver Declaraciones - Vehiculos',
            'Mi Perfil'
        ]);

        $rolePublicAttention = Role::create(['name' => 'Atención al Público']);
        $rolePublicAttention->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Historial de Pago - Vehiculos',
            'Mi Perfil'
        ]);

        $rolePaymentConciliator = Role::create(['name' => 'Conciliador de Pagos']);
        $rolePaymentConciliator->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Pagos',
            'Registrar Pago',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Cargar Archivo Pagos',
            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
            'Ver Planillas',
            'Mi Perfil'
        ]);

        $roleCoordinator = Role::create(['name' => 'Coordinador - Taquilla']);
        $roleCoordinator ->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Pagos',
            'Registrar Pago',
            'Registrar Pago - Transferencias',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Cargar Archivo Pagos',
            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
            'Ver Pagos - Transferencias',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
            'Ver Planillas',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Usuarios',
            'Registar Usuario',
            'Consultar Usuarios',
            'Detalles Usuarios',
            'Actualizar Usuarios',
            'Habilitar/Deshabilitar Usuarios',
            'Resetear Usuarios',
            'Mi Perfil'
        ]);

        $roleAdministrator = Role::create(['name' => 'Administrador']);
        $roleAdministrator->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Pagos',
            'Registrar Pago',
            'Registrar Pago - Transferencias',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Cargar Archivo Pagos',
            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
            'Ver Pagos - Transferencias',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
            'Ver Planillas',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Historial de Pago - Vehiculos',
            'Configuración',
            'Gestionar Unidad Tribuaria',
            'Registar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registar Ramo CIIU',
            'Consultar Ramos CIIU',
            'Detalles Ramo CIIU',
            'Actualizar Ramos CIIU',
            'Notificaciones',
            'Registrar Notificaciones',
            'Consultar Notificaciones',
            'Ver Notificaciones',
            'Mi Perfil'
        ]);

        $roleCollectionManager = Role::create(['name' => 'Gerente de Recaudación']);
        $roleCollectionManager->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Pagos',
            'Registrar Pago',
            'Registrar Pago - Transferencias',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
            'Anular Pagos',
            'Verificar Pagos - Manual',
            'Verificar Pagos - Archivo',
            'Cargar Archivo Pagos',
            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
            'Ver Pagos - Transferencias',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
            'Ver Planillas',
            'Gestionar Empresas',
            'Registar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Historial de Pago - Vehiculos',
            'Configuración',
            'Gestionar Unidad Tribuaria',
            'Registar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registar Ramo CIIU',
            'Consultar Ramos CIIU',
            'Detalles Ramo CIIU',
            'Actualizar Ramos CIIU',
            'GeoSEMAT',
            'Estadisticas',
            'Mi Perfil'
        ]);

        $roleMayor = Role::create(['name' => 'Alcalde']);
        $roleMayor->givePermissionTo([
            'GeoSEMAT',
            'Estadisticas',
            'Gestionar Empresas',
            'Consultar Empresas',
            'Detalles Empresas',
            'Mi Perfil'
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
