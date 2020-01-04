<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TypeVehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vehicle_type')->insert([
            'name'=>'Motocicletas, Motonetas y similares',
            'rate'=>50,
            'rate_UT'=>18,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('vehicle_type')->insert([
            'name'=>'Automóvil y Camionetas de pasajeros',
            'rate'=>100,
            'rate_UT'=>33,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('vehicle_type')->insert([
            'name'=>'Minibuses',
            'rate'=>200,
            'rate_UT'=>100,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('vehicle_type')->insert([
            'name'=>'Autobuses',
            'rate'=>300,
            'rate_UT'=>150,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('vehicle_type')->insert([
            'name'=>'Vehículo de carga hasta 12 Toneladas',
            'rate'=>400,
            'rate_UT'=>200,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('vehicle_type')->insert([
            'name'=>'Vehículo de carga peso mayor a 12 toneladas',
            'rate'=>500,
            'rate_UT'=>250,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
