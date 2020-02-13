<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GroupPublicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_publicity')->insert([
        	'name' => 'Publicidad por Tiempo',
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('group_publicity')->insert([
        	'name' => 'Publicidad por Tamaño',
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('group_publicity')->insert([
        	'name' => 'Publicidad por Cantidad',
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('group_publicity')->insert([
        	'name' => 'Publicidad por Eventual',
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('group_publicity')->insert([
        	'name' => 'Publicidad por Vallas',
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
