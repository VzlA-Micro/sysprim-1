<?php

use Illuminate\Database\Seeder;

class CompanyRespaldoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/seeds/register/register_company.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $path = base_path() . '/database/seeds/register/sql_sysprim_inmueble/value_catastral_construccion.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $path = base_path() . '/database/seeds/register/sql_sysprim_inmueble/value_catastral_terreno.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $path = base_path() . '/database/seeds/register/sql_sysprim_vehicle/brands.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $path = base_path() . '/database/seeds/register/sql_sysprim_vehicle/models_new.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}