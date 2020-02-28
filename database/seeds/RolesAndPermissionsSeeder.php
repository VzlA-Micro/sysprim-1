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

        #########################################################################################################
        # !!!!!!!!!!!!!!!!!!!  ------>                SUPERUSUARIO               <-------   !!!!!!!!!!!!!!!!!!! #
        #########################################################################################################
        # +++++++++++  SEGURIDAD
        Permission::create(['name' => 'Seguridad']);
        # +++++++++++  BITACORA
        Permission::create(['name' => 'Bitacora']);
        # +++++++++++  ROLES Y PERMISOS
        Permission::create(['name' => 'Gestionar Roles y Permisos']);
        Permission::create(['name' => 'Crear Rol']);
        Permission::create(['name' => 'Ver Roles']);
        Permission::create(['name' => 'Actualizar Roles']);
        Permission::create(['name' => 'Detalles Roles']);
        // Permission::create(['name' => 'Eliminar Roles']);

        # +++++++++++  GESTIONAR USUARIOS
        Permission::create(['name' => 'Gestionar Usuarios']);
        Permission::create(['name' => 'Registrar Usuario']);
        Permission::create(['name' => 'Consultar Usuarios']);
        Permission::create(['name' => 'Detalles Usuarios']);
        Permission::create(['name' => 'Actualizar Usuarios']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Usuarios']);
        // Permission::create(['name' => 'Eliminar Usuarios']);
        Permission::create(['name' => 'Resetear Usuarios']);
        Permission::create(['name' => 'Mi Perfil']);

        ###########################################################################
        /*                            CONFIGURACION                              */
        ###########################################################################
        Permission::create(['name' => 'Configuración']);
        Permission::create(['name' => 'Configuración - Actividad Económica']);
        Permission::create(['name' => 'Configuración - Vehículos']);
        Permission::create(['name' => 'Configuración - Inmuebles']);
        Permission::create(['name' => 'Configuración - Publicidad']);
        Permission::create(['name' => 'Configuración - General']);


        /* ------- GESTIONAR UNIDAD TRIBUTARIA ------ */
        Permission::create(['name' => 'Gestionar Unidad Tribuaria']);
        Permission::create(['name' => 'Registrar Unidad Tribuaria']);
        Permission::create(['name' => 'Consultar Unidades Tribuarias']);

        /* ------- GESTIONAR CIIU ------ */
        Permission::create(['name' => 'Gestionar CIIU']);
        Permission::create(['name' => 'Registrar Grupo CIIU']);
        Permission::create(['name' => 'Consultar Grupos CIIU']);
        /* ------- GESTIONAR RAMOS CIIU ------ */
        Permission::create(['name' => 'Gestionar Ramos CIIU']);
        Permission::create(['name' => 'Registrar Ramo CIIU']);
        Permission::create(['name' => 'Consultar Ramos CIIU']);
        Permission::create(['name' => 'Detalles Ramo CIIU']);
        Permission::create(['name' => 'Actualizar Ramos CIIU']);

        // -- Gestionar Tipos de Vehiculos
        Permission::create(['name' => 'Gestionar Tipos de Vehiculos']);
        Permission::create(['name' => 'Registrar Tipo de Vehiculo']);
        Permission::create(['name' => 'Consultar Tipos de Vehiculos']);
        Permission::create(['name' => 'Detalles Tipo de Vehiculos']);
        Permission::create(['name' => 'Actualizar Tipos de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Tipos de Vehiculos']);

        // -- Gestionar Marcas de Vehiculos
        Permission::create(['name' => 'Gestionar Marcas de Vehiculos']);
        Permission::create(['name' => 'Registrar Marca de Vehiculo']);
        Permission::create(['name' => 'Consultar Marcas de Vehiculos']);
        Permission::create(['name' => 'Detalles Marca de Vehiculos']);
        Permission::create(['name' => 'Actualizar Marcas de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Marcas de Vehiculos']);

        // -- Gestionar Modelos de Vehiculos
        Permission::create(['name' => 'Gestionar Modelos de Vehiculos']);
        Permission::create(['name' => 'Registrar Modelo de Vehiculo']);
        Permission::create(['name' => 'Consultar Modelos de Vehiculos']);
        Permission::create(['name' => 'Detalles Modelo de Vehiculos']);
        Permission::create(['name' => 'Actualizar Modelos de Vehiculos']);
        // Permission::create(['name' => 'Eliminar Modelos de Vehiculos']);


        // -- Gestionar Recargos
        Permission::create(['name' => 'Gestionar Recargos']);
        Permission::create(['name' => 'Registrar Recargo']);
        Permission::create(['name' => 'Consultar Recargos']);
        Permission::create(['name' => 'Detalles Recargo']);
        Permission::create(['name' => 'Actualizar Recargos']);
        // Permission::create(['name' => 'Eliminar Recargos']);

        // -- Gestionar Accessorios
        Permission::create(['name' => 'Gestionar Accesorios']);
        Permission::create(['name' => 'Registrar Accesorio']);
        Permission::create(['name' => 'Consultar Accesorios']);
        Permission::create(['name' => 'Detalles Accesorio']);
        Permission::create(['name' => 'Actualizar Accesorios']);
        // Permission::create(['name' => 'Eliminar Accesorios']);

        // -- Grupo de Publicidad
        Permission::create(['name' => 'Gestionar Grupos de Publicidad']);
        Permission::create(['name' => 'Registrar Grupo de Publicidad']);
        Permission::create(['name' => 'Consultar Grupos de Publicidad']);
        Permission::create(['name' => 'Detalles Grupo de Publicidad']);
        Permission::create(['name' => 'Actualizar Grupo de Publicidad']);

        // -- Gestionar Tipos de Publicidad
        Permission::create(['name' => 'Gestionar Tipos de Publicidad']);
        Permission::create(['name' => 'Registrar Tipo de Publicidad']);
        Permission::create(['name' => 'Consultar Tipos de Publicidad']);
        Permission::create(['name' => 'Detalles Tipo de Publicidad']);
        Permission::create(['name' => 'Actualizar Tipos de Publicidad']);
        // Permission::create(['name' => 'Eliminar Tipos de Publicidad']);


        // -- Tasas del Banco
        Permission::create(['name' => 'Gestionar Tasas del Banco']);
        Permission::create(['name' => 'Registrar Tasa de Banco']);
        Permission::create(['name' => 'Consultar Tasas del Banco']);
        Permission::create(['name' => 'Detalles Tasa de Banco']);
        Permission::create(['name' => 'Actualizar Tasa de Banco']);
        // Permission::create(['name' => 'Eliminar Tasa de Banco']);

        // -- Tasas
        Permission::create(['name' => 'Gestionar Tasas']);
        Permission::create(['name' => 'Registrar Tasa']);
        Permission::create(['name' => 'Consultar Tasas']);
        Permission::create(['name' => 'Detalles Tasa']);
        Permission::create(['name' => 'Actualizar Tasa']);
        // Permission::create(['name' => 'Eliminar Tasa']);

        // -- Dias de Cobro
        Permission::create(['name' => 'Gestionar Dias de Cobro']);
//        Permission::create(['name' => 'Registrar Dia de Cobro']);
        Permission::create(['name' => 'Consultar Dias de Cobro']);
        Permission::create(['name' => 'Detalles Dia de Cobro']);
        Permission::create(['name' => 'Actualizar Dia de Cobro']);

        // -- Alicuota de Inmueble
        Permission::create(['name' => 'Gestionar Alicuotas']);
//        Permission::create(['name' => 'Registrar Alicuota']);
        Permission::create(['name' => 'Consultar Alicuotas']);
        Permission::create(['name' => 'Detalles Alicuota']);
        Permission::create(['name' => 'Actualizar Alicuota']);

        // -- Valores Catastrales - Construccion
        Permission::create(['name' => 'Gestionar Catastral Construccion']);
        Permission::create(['name' => 'Registrar Valor Construccion']);
        Permission::create(['name' => 'Consultar Valores Construccion']);
        Permission::create(['name' => 'Detalles Valor Construccion']);
        Permission::create(['name' => 'Actualizar Valor Construccion']);

        // -- Valores Catastrales - Terreno
        Permission::create(['name' => 'Gestionar Catastral Terreno']);
        Permission::create(['name' => 'Registrar Valor Terreno']);
        Permission::create(['name' => 'Consultar Valores Terreno']);
        Permission::create(['name' => 'Detalles Valor Terreno']);
        Permission::create(['name' => 'Actualizar Valor Terreno']);

        // ---------------- Taquilla ---------------------- //
        Permission::create(['name' => 'Taquillas']);
        Permission::create(['name' => 'Taquilla - Actividad Económica']);
        Permission::create(['name' => 'Taquilla - Vehiculos']);
        Permission::create(['name' => 'Taquilla - Tasas']);
        Permission::create(['name' => 'Taquilla - Inmuebles']);
        Permission::create(['name' => 'Taquilla - Publicidad']);
        Permission::create(['name' => 'Configurar Taquilla']);


        // Permission::create(['name' => 'Taquilla - Inmuebles']);
        // Permission::create(['name' => 'Taquilla - Publicidad']);


        // -- Gestionar Contribuyente
        Permission::create(['name' => 'Gestionar Contribuyentes']);
        Permission::create(['name' => 'Registrar Contribuyente']);
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
//        Permission::create(['name' => 'Verificar/Anular Planilla']);
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
        Permission::create(['name' => 'Ver Planilla PDF']);

        // -- Gestionar Empresas
        Permission::create(['name' => 'Gestionar Empresas']);
        Permission::create(['name' => 'Registrar Empresa']);
        Permission::create(['name' => 'Consultar Empresas']);
        Permission::create(['name' => 'Detalles Empresas']);
        Permission::create(['name' => 'Actualizar Empresas']);
        // Permission::create(['name' => 'Eliminar Empresas']);
        Permission::create(['name' => 'Gestionar Pagos - Actividad Económica']);
        Permission::create(['name' => 'Añadir CIIU Empresas']);
        Permission::create(['name' => 'Eliminar CIIU Empresas']);
        Permission::create(['name' => 'Habilitar/Deshabilitar CIIU Empresas']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Empresas']);
        Permission::create(['name' => 'Cambiar Ubicacion - Empresa']);
        Permission::create(['name' => 'Cambiar Usuario - Empresa']);
        Permission::create(['name' => 'Historial de Pago - Empresas']);

        // -- Gestionar Inmuebles
        Permission::create(['name' => 'Gestionar Inmuebles']);
        Permission::create(['name' => 'Registrar Inmueble']);
        Permission::create(['name' => 'Consultar Inmuebles']);
        Permission::create(['name' => 'Detalles Inmuebles']);
        Permission::create(['name' => 'Actualizar Inmuebles']);
        Permission::create(['name' => 'Gestionar Pagos - Inmuebles']);
        Permission::create(['name' => 'Cambiar Ubicacion - Inmuebles']);
        Permission::create(['name' => 'Cambiar Propietario - Inmueble']);
        Permission::create(['name' => 'Cambiar Usuario - Inmueble']);
        Permission::create(['name' => 'Historial de Pago - Inmuebles']);
//        Permission::create(['name' => 'Historial de Pago - Inmuebles']);

        // Permission::create(['name' => 'Eliminar Inmuebles']);
//        Permission::create(['name' => 'Historial de Pago - Inmuebles']);


        Permission::create(['name' => 'Tasas - Generar Planilla']);
        Permission::create(['name' => 'Tasas - Pagar Planillas']);
        Permission::create(['name' => 'Tasas - Detalles Planilla']);


        // -- Gestionar Publicidad
        Permission::create(['name' => 'Gestionar Publicidad']);
        Permission::create(['name' => 'Registrar Publicidad']);
        Permission::create(['name' => 'Consultar Publicidad']);
        Permission::create(['name' => 'Detalles Publicidad']);
        Permission::create(['name' => 'Actualizar Publicidad']);
        Permission::create(['name' => 'Gestionar Pagos - Publicidad']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Publicidad']);

//        Permission::create(['name' => 'Cambiar Ubicacion - Inmuebles']);
//        Permission::create(['name' => 'Cambiar Propietario - Inmueble']);
        Permission::create(['name' => 'Cambiar Usuario - Publicidad']);
        Permission::create(['name' => 'Historial de Pago - Publicidad']);


        // -- Gestionar Vehiculos
        Permission::create(['name' => 'Gestionar Vehiculos']);
        Permission::create(['name' => 'Registrar Vehiculo']);
        Permission::create(['name' => 'Consultar Vehiculos']);
        Permission::create(['name' => 'Detalles Vehiculos']);
        Permission::create(['name' => 'Actualizar Vehiculos']);
        // Permission::create(['name' => 'Eliminar Vehiculos']);
        Permission::create(['name' => 'Gestionar Pagos - Vehiculos']);
        Permission::create(['name' => 'Cambiar Ubicacion - Vehiculos']);
        Permission::create(['name' => 'Cambiar Propietario - Vehiculo']);
        Permission::create(['name' => 'Cambiar Usuario - Vehiculo']);
        Permission::create(['name' => 'Habilitar/Deshabilitar Vehiculo']);
        Permission::create(['name' => 'Historial de Pago - Vehiculos']);

        // GeoSEMAT

        Permission::create(['name' => 'GeoSEMAT']);

        // Estadisticas
        Permission::create(['name' => 'Estadisticas']);
        Permission::create(['name' => 'Estadisticas - SuperUsuario']);
        Permission::create(['name' => 'Estadisticas - Bancos']);
        Permission::create(['name' => 'Estadisticas - Pagos']);
        Permission::create(['name' => 'Estadisticas - Recaudación']);




        // Notificaciones
        Permission::create(['name' => 'Notificaciones']);
        Permission::create(['name' => 'Registrar Notificaciones']);
        Permission::create(['name' => 'Consultar Notificaciones']);
        Permission::create(['name' => 'Ver Notificaciones']);

        #######################################################################################################
        ############ -----------------------    GESTION DE USUARIO WEB    ------------------------ ############
        #######################################################################################################

        # >>>>>>>>> ACTIVIDAD ECONOMICA
        Permission::create(['name' => 'Mis Empresas']);
        Permission::create(['name' => 'Registrar Mis Empresas']);
        Permission::create(['name' => 'Consultar Mis Empresas']);
        Permission::create(['name' => 'Detalles Mis Empresas']);
        Permission::create(['name' => 'Actualizar Mis Empresas']);
        // Permission::create(['name' => 'Eliminar Mis Empresas']);
        Permission::create(['name' => 'Mis Pagos - Actividad Económica']);
        Permission::create(['name' => 'Declarar Actividad Económica']);
        Permission::create(['name' => 'Declaración Anticipada - Actividad Económica']);
        Permission::create(['name' => 'Declaración Definitiva - Actividad Económica']);
        Permission::create(['name' => 'Historial de Pagos - Actividad Económica']);
        Permission::create(['name' => 'Pagar Actividad Económica']);

        # >>>>>>>>> INMUEBLES
        Permission::create(['name' => 'Mis Inmuebles']);
        Permission::create(['name' => 'Registrar Mis Inmuebles']);
        Permission::create(['name' => 'Consultar Mis Inmuebles']);
        Permission::create(['name' => 'Detalles Mis Inmuebles']);
        Permission::create(['name' => 'Actualizar Mis Inmuebles']);
        // Permission::create(['name' => 'Eliminar Mis Inmuebles']);
        Permission::create(['name' => 'Mis Pagos - Inmuebles']);
        Permission::create(['name' => 'Declarar Inmuebles']);
        Permission::create(['name' => 'Historial de Pagos - Inmuebles']);


        Permission::create(['name' => 'Pagar Inmueble']);
//        Permission::create(['name' => 'Detalles de Pago - Inmueble']);

        # >>>>>>>>> VEHICULOS
        Permission::create(['name' => 'Mis Vehiculos']);
        Permission::create(['name' => 'Registrar Mis Vehiculos']);
        Permission::create(['name' => 'Consultar Mis Vehiculos']);
        Permission::create(['name' => 'Detalles Mis Vehiculos']);
        Permission::create(['name' => 'Actualizar Mis Vehiculos']);
        // Permission::create(['name' => 'Eliminar Mis Vehiculos']);
        Permission::create(['name' => 'Mis Pagos - Vehiculos']);
        Permission::create(['name' => 'Declarar Vehiculos']);
        Permission::create(['name' => 'Historial de Pagos - Vehiculos']);
        Permission::create(['name' => 'Pagar Vehiculo']);


        # >>>>>>>>> TASAS
        Permission::create(['name' => 'Generar Tasas']);
        Permission::create(['name' => 'Declarar Tasas']);
        Permission::create(['name' => 'Mis Pagos - Tasas']);
        Permission::create(['name' => 'Historial de Pagos - Tasas']);
        Permission::create(['name' => 'Pagar Tasas']);


        # >>>>>>>>> PUBLICIDAD
        Permission::create(['name' => 'Mis Publicidades']);
        Permission::create(['name' => 'Registrar Mis Publicidades']);
        Permission::create(['name' => 'Consultar Mis Publicidades']);
        Permission::create(['name' => 'Detalles Mis Publicidades']);
        Permission::create(['name' => 'Actualizar Mis Publicidades']);
        // Permission::create(['name' => 'Eliminar Mis Publicidades']);
        Permission::create(['name' => 'Mis Pagos - Publicidad']);
        Permission::create(['name' => 'Declarar Publicidades']);
        Permission::create(['name' => 'Historial de Pagos - Publicidades']);


        # >>>>>>>>> GENERAL USUARIO WEB
        Permission::create(['name' => 'Detalles Mi Planilla']);
        Permission::create(['name' => 'Descargar Mi Planilla']);
        Permission::create(['name' => 'Obtener Mi Planilla']);

        #######################################################################################################

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
            'Registrar Usuario',
            'Consultar Usuarios',
            'Detalles Usuarios',
            'Actualizar Usuarios',
            'Habilitar/Deshabilitar Usuarios',
            'Resetear Usuarios',
            'Configuración',
            'Configuración - Actividad Económica',
            'Configuración - Vehículos',
            'Configuración - Inmuebles',
            'Configuración - Publicidad',
            'Configuración - General',
            'Gestionar Unidad Tribuaria',
            'Registrar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registrar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registrar Ramo CIIU',
            'Consultar Ramos CIIU',
            'Detalles Ramo CIIU',
            'Actualizar Ramos CIIU',
            'Gestionar Tipos de Vehiculos',
            'Registrar Tipo de Vehiculo',
            'Consultar Tipos de Vehiculos',
            'Detalles Tipo de Vehiculos',
            'Actualizar Tipos de Vehiculos',
            'Gestionar Marcas de Vehiculos',
            'Registrar Marca de Vehiculo',
            'Consultar Marcas de Vehiculos',
            'Detalles Marca de Vehiculos',
            'Actualizar Marcas de Vehiculos',
            'Gestionar Modelos de Vehiculos',
            'Registrar Modelo de Vehiculo',
            'Consultar Modelos de Vehiculos',
            'Detalles Modelo de Vehiculos',
            'Actualizar Modelos de Vehiculos',
            'Gestionar Recargos',
            'Registrar Recargo',
            'Consultar Recargos',
            'Detalles Recargo',
            'Actualizar Recargos',
            'Gestionar Accesorios',
            'Registrar Accesorio',
            'Consultar Accesorios',
            'Detalles Accesorio',
            'Actualizar Accesorios',
            'Gestionar Tipos de Publicidad',
            'Registrar Tipo de Publicidad',
            'Consultar Tipos de Publicidad',
            'Detalles Tipo de Publicidad',
            'Actualizar Tipos de Publicidad',
            'Gestionar Grupos de Publicidad',
            'Registrar Grupo de Publicidad',
            'Consultar Grupos de Publicidad',
            'Detalles Grupo de Publicidad',
            'Actualizar Grupo de Publicidad',
            'Gestionar Tasas del Banco',
            'Registrar Tasa de Banco',
            'Consultar Tasas del Banco',
            'Detalles Tasa de Banco',
            'Actualizar Tasa de Banco',
            'Gestionar Tasas',
            'Registrar Tasa',
            'Consultar Tasas',
            'Detalles Tasa',
            'Actualizar Tasa',
            'Gestionar Dias de Cobro',
            'Consultar Dias de Cobro',
            'Detalles Dia de Cobro',
            'Actualizar Dia de Cobro',
            'Gestionar Alicuotas',
            'Consultar Alicuotas',
            'Detalles Alicuota',
            'Actualizar Alicuota',
            'Gestionar Catastral Construccion',
            'Registrar Valor Construccion',
            'Consultar Valores Construccion',
            'Detalles Valor Construccion',
            'Actualizar Valor Construccion',
            'Gestionar Catastral Terreno',
            'Registrar Valor Terreno',
            'Consultar Valores Terreno',
            'Detalles Valor Terreno',
            'Actualizar Valor Terreno',
            'Taquillas',
            'Configurar Taquilla',
            ##### GESTIONAR CONTRIBUYENTE #####
            'Gestionar Contribuyentes',
            'Registrar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            ##### TAQUILLA DE ACTIVIDAD ECONOMICA #####
            'Taquilla - Actividad Económica',
            'Gestionar Empresas',
            'Registrar Empresa',
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
            'Gestionar Pagos - Actividad Económica',
            # --------------------------------------- #
            ##### PLANILLA DE VEHICULOS #####
            'Taquilla - Vehiculos',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Gestionar Pagos - Vehiculos',
            'Cambiar Ubicacion - Vehiculos',
            'Cambiar Propietario - Vehiculo',
            'Cambiar Usuario - Vehiculo',
            'Habilitar/Deshabilitar Vehiculo',
            'Historial de Pago - Vehiculos',
            # ----------------------------- #
            ##### TAQUILLA DE TASAS #####
            'Taquilla - Tasas',
            'Tasas - Generar Planilla',
            'Tasas - Pagar Planillas',
            'Tasas - Detalles Planilla',
            # ------------------------- #
            ##### TAQUILLA DE INMUEBLES #####
            'Taquilla - Inmuebles',
            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Gestionar Pagos - Inmuebles',
            'Cambiar Ubicacion - Inmuebles',
            'Cambiar Propietario - Inmueble',
            'Cambiar Usuario - Inmueble',
            'Historial de Pago - Inmuebles',
            # ------------------------- #
            ##### TAQUILLA DE PUBLICIDAD #####
            'Taquilla - Publicidad',
            'Gestionar Publicidad',
            'Registrar Publicidad',
            'Consultar Publicidad',
            'Detalles Publicidad',
            'Actualizar Publicidad',
            'Gestionar Pagos - Publicidad',
            'Cambiar Usuario - Publicidad',
            'Habilitar/Deshabilitar Publicidad',
            'Historial de Pago - Publicidad',
            # ----------------------------- #
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

            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'GeoSEMAT',
            'Estadisticas',
            'Estadisticas - SuperUsuario',
            'Estadisticas - Bancos',
            'Estadisticas - Pagos',
            'Estadisticas - Recaudación',
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
            ##### GESTIONAR CONTRIBUYENTE #####
            'Gestionar Contribuyentes',
            'Registrar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            ##### TAQUILLA DE ACTIVIDAD ECONOMICA #####
            'Taquilla - Actividad Económica',
            'Gestionar Empresas',
            'Registrar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
//            'Actualizar Empresas',
//            'Añadir CIIU Empresas',
//            'Eliminar CIIU Empresas',
//            'Habilitar/Deshabilitar CIIU Empresas',
//            'Habilitar/Deshabilitar Empresas',
            'Cambiar Ubicacion - Empresa',
            'Cambiar Usuario - Empresa',
            'Historial de Pago - Empresas',
            'Gestionar Pagos - Actividad Económica',
            # --------------------------------------- #
            ##### PLANILLA DE VEHICULOS #####
            'Taquilla - Vehiculos',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Gestionar Pagos - Vehiculos',
//            'Cambiar Propietario - Vehiculo',
            'Cambiar Usuario - Vehiculo',
//            'Habilitar/Deshabilitar Vehiculo',
            'Historial de Pago - Vehiculos',
            # ----------------------------- #
            ##### TAQUILLA DE TASAS #####
            'Taquilla - Tasas',
            'Tasas - Generar Planilla',
            'Tasas - Pagar Planillas',
            'Tasas - Detalles Planilla',
            # ------------------------- #
            ##### TAQUILLA DE INMUEBLES #####
            'Taquilla - Inmuebles',
            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
//            'Actualizar Inmuebles',
            'Gestionar Pagos - Inmuebles',
            'Cambiar Ubicacion - Inmuebles',
//            'Cambiar Propietario - Inmueble',
            'Cambiar Usuario - Inmueble',
            'Historial de Pago - Inmuebles',
            # ------------------------- #
            ##### TAQUILLA DE PUBLICIDAD #####
            'Taquilla - Publicidad',
            'Gestionar Publicidad',
            'Registrar Publicidad',
            'Consultar Publicidad',
            'Detalles Publicidad',
//            'Actualizar Publicidad',
            'Gestionar Pagos - Publicidad',
            'Cambiar Usuario - Publicidad',
            'Historial de Pago - Publicidad',
            # ------------------------- #
            'Gestionar Pagos',
            'Registrar Pago',
//            'Registrar Pago - Transferencias',
            'Registrar Pago - Punto de Venta',
            'Registrar Pago - Depositos',
            'Detalles Pagos',
//            'Anular Pagos',
//            'Verificar Pagos - Manual',
//            'Verificar Pagos - Archivo',
//            'Cargar Archivo Pagos',
//            'Ver Pagos verificados',
            'Generar Planilla',
            'Detalles Planilla',
            'Pagar Planilla',
            'Ver Pagos',
//            'Ver Pagos - Transferencias',
//            'Ver Pagos - Punto de Venta',
//            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Escanear QR',
            'Taquilla - Caja',
            'Abrir/Cerrar Caja',
//            'Ver Planillas',
            'Ver Planilla PDF',
            'Mi Perfil'
        ]);

        // Contribuyente
        $roleTaxpayer = Role::create(['name' => 'Contribuyente']);
        $roleTaxpayer->givePermissionTo([
            # ------ Módulo de Mis Empresas
            'Mis Empresas',
            'Registrar Mis Empresas',
            'Consultar Mis Empresas',
            'Detalles Mis Empresas',
            // 'Actualizar Mis Empresas',

            'Mis Pagos - Actividad Económica',
            'Declarar Actividad Económica',
            'Declaración Anticipada - Actividad Económica',
            'Declaración Definitiva - Actividad Económica',
            'Historial de Pagos - Actividad Económica',

            # ------- Módulo de Mis Inmuebles
            'Mis Inmuebles',
            'Registrar Mis Inmuebles',
            'Consultar Mis Inmuebles',
            'Detalles Mis Inmuebles',
//            'Actualizar Mis Inmuebles',
            // 'Eliminar Mis Inmuebles',
            'Mis Pagos - Inmuebles',
            'Declarar Inmuebles',
            'Historial de Pagos - Inmuebles',
            'Pagar Inmueble',

            # -------- Módulo de Mis Vehiculos
            'Mis Vehiculos',
            'Registrar Mis Vehiculos',
            'Consultar Mis Vehiculos',
            'Detalles Mis Vehiculos',
            'Actualizar Mis Vehiculos',
            // 'Eliminar Mis Vehiculos',
            'Mis Pagos - Vehiculos',
            'Declarar Vehiculos',
            'Historial de Pagos - Vehiculos',
            'Pagar Vehiculo',

            # --------- Módulo de Mis Publicidades
            'Mis Publicidades',
            'Registrar Mis Publicidades',
            'Consultar Mis Publicidades',
            'Detalles Mis Publicidades',
            // 'Actualizar Mis Publicidades',
            // 'Eliminar Mis Publicidades',
            'Mis Pagos - Publicidad',
            'Declarar Publicidades',
            'Historial de Pagos - Publicidades',

            # --------- Módulo de Mis Tasas
            'Generar Tasas',
            'Declarar Tasas',
            'Mis Pagos - Tasas',
            'Historial de Pagos - Tasas',
            'Pagar Tasas',

            #  ---------------------------------------


            # ------- GENERAL PARA EL USUARIO WEB
            'Detalles Mi Planilla',
            'Descargar Mi Planilla',
            'Obtener Mi Planilla',
            'Mi Perfil'
        ]);

        $rolePublicAttention = Role::create(['name' => 'Atención al Público']);
        $rolePublicAttention->givePermissionTo([
            'Taquillas',
            'Taquilla - Actividad Económica',
            'Gestionar Contribuyentes',
            'Registrar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Gestionar Empresas',
            'Registrar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
//            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
//            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
//            'Historial de Pago - Vehiculos',
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
            'Configurar Taquilla',
            'Gestionar Contribuyentes',
            'Registrar Contribuyente',
            'Consultar Contribuyentes',
            'Detalles Contribuyentes',
            'Actualizar Contribuyentes',
            'Resetear Contribuyentes',
            'Taquilla - Tasas',
            'Ver Planilla PDF',
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
            'Ver Planilla PDF',
            'Taquilla - Actividad Económica',
            'Gestionar Empresas',
            'Registrar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Taquilla - Vehiculos',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Habilitar/Deshabilitar Vehiculo',
            'Historial de Pago - Vehiculos',
            'Gestionar Usuarios',
            'Registrar Usuario',
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
            'Registrar Contribuyente',
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
            'Registrar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
//            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Historial de Pago - Vehiculos',
            'Configuración',
            'Gestionar Unidad Tribuaria',
            'Registrar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registrar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registrar Ramo CIIU',
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
            'Registrar Contribuyente',
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
            'Registrar Empresa',
            'Consultar Empresas',
            'Detalles Empresas',
            'Actualizar Empresas',
            'Añadir CIIU Empresas',
            'Eliminar CIIU Empresas',
            'Habilitar/Deshabilitar CIIU Empresas',
            'Historial de Pago - Empresas',
            'Gestionar Inmuebles',
            'Registrar Inmueble',
            'Consultar Inmuebles',
            'Detalles Inmuebles',
            'Actualizar Inmuebles',
//            'Historial de Pago - Inmuebles',
            'Gestionar Vehiculos',
            'Registrar Vehiculo',
            'Consultar Vehiculos',
            'Detalles Vehiculos',
            'Actualizar Vehiculos',
            'Historial de Pago - Vehiculos',
            'Configuración',
            'Gestionar Unidad Tribuaria',
            'Registrar Unidad Tribuaria',
            'Consultar Unidades Tribuarias',
            'Gestionar CIIU',
            'Registrar Grupo CIIU',
            'Consultar Grupos CIIU',
            'Gestionar Ramos CIIU',
            'Registrar Ramo CIIU',
            'Consultar Ramos CIIU',
            'Detalles Ramo CIIU',
            'Actualizar Ramos CIIU',
            'GeoSEMAT',
            'Estadisticas',
            'Estadisticas - Bancos',
            'Estadisticas - Pagos',
            'Estadisticas - Recaudación',
            'Mi Perfil'
        ]);

        $roleMayor = Role::create(['name' => 'Alcalde']);
        $roleMayor->givePermissionTo([
            'GeoSEMAT',
            'Estadisticas',
            'Estadisticas - Bancos',
            'Estadisticas - Pagos',
            'Estadisticas - Recaudación',
            'Gestionar Empresas',
            'Consultar Empresas',
            'Detalles Empresas',
            'Mi Perfil'
        ]);

        $roleTreasurer = Role::create(['name' => 'Tesorero']);
        $roleTreasurer->givePermissionTo([
            'Taquillas',
            'Ver Pagos',
            'Ver Pagos - Transferencias',
            'Ver Pagos - Punto de Venta',
            'Ver Pagos - Depositos',
            'Mi Taquilla - Punto de Venta',
            'Mi Taquilla - Deposito',
            'Ver Planillas - Taquilla',
            'Detalles Pagos',
            'Ver Planillas',
            'Detalles Planilla',
            'Ver Planilla PDF',
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

        DB::table('model_has_roles')->insert([
            'role_id' => 6,
            'model_type' => 'App\User',
            'model_id' => 4
        ]);
    }
}
