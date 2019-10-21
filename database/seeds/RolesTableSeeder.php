<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'Super Usuario',
            'description'=>'Persona la cual posee acceso a todo las funcionalidades del sistema',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name'=>'Ticket Office',
            'description'=>'persona encargada de la taquilla de atencion al usuario',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
