<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class AccessoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accessories')->insert([
            'name' => 'PUBLICIDAD EN TERRENOS EJIDOS O DEL MUNICIPIO',
            'value' => 5000,
            'branch' => 'Prop. y Publicidad',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('accessories')->insert([
            'name' => 'PUBLICIDAD REFERENTE A CIGARRILLOS O BEBIDAS ALCOHOLICAS',
            'value' => 5000,
            'branch' => 'Prop. y Publicidad',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('accessories')->insert([
            'name' => 'PUNTOS DE PUBLICIDAD',
            'value' => 1000,
            'branch' => 'Prop. y Publicidad',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('accessories')->insert([
            'name' => 'DEPOSITO DE RETIRO DE MEDIO PUBLICITARIO',
            'value' => 200,
            'branch' => 'Prop. y Publicidad',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
