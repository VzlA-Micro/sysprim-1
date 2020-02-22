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

        DB::table('vehicle_type')->insert([
            'name'=>'Motocicletas, Motonetas y similares',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>1,
            'rate'=>50,
            'rate_UT'=>18
        ]);

        DB::table('vehicle_type')->insert([
            'name'=>'Automóvil y Camionetas de pasajeros',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>2,
            'rate'=>100,
            'rate_UT'=>33
        ]);

        DB::table('vehicle_type')->insert([
            'name'=>'Minibuses',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>3,
            'rate'=>200,
            'rate_UT'=>100
        ]);

        DB::table('vehicle_type')->insert([
            'name'=>'Autobuses',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>4,
            'rate'=>300,
            'rate_UT'=>150
        ]);

        DB::table('vehicle_type')->insert([
            'name'=>'Vehículo de carga hasta 12 Toneladas',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>5,
            'rate'=>400,
            'rate_UT'=>200
        ]);

        DB::table('vehicle_type')->insert([
            'name'=>'Vehículo de carga peso mayor a 12 toneladas',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_type_vehicle')->insert([
            'type_vehicle_id'=>6,
            'rate'=>500,
            'rate_UT'=>250
        ]);
    }
}
