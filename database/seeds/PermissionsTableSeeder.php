<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'=>'Todo',
            'description'=>'Puede acceder a todo los modulos',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name'=>'Registrar empresa',
            'description'=>'Puede registrar empresas',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
