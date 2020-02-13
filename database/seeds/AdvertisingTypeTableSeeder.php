<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdvertisingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad eventual u ocasional',
            'value' => 45,
            'group_publicity_id'=>4,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad de folletos, hojas impresas, afiches o similares',
            'value' => 125,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad encartada en los medios de comunicación impresos',
            'value' => 125,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Afiches o similares',
            'value' => 125,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en bonos, billetes, boletos, cupones y similares',
            'value' => 125,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en prendas de vestir, articulos u objetos diversos',
            'value' => 125,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad por medio de aviones, helicópteros, globos dirigibles o aerostáticos y medios similares',
            'value' => 1000,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
            'name' => 'Publicidad por medio de globos fijos',
            'value' => 50,
            'group_publicity_id'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad por medio de megáfonos',
            'value' => 75,
            'group_publicity_id'=>1,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en anuncios, avisos y similares',
            'value' => 60,
            'group_publicity_id'=>2,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Avisos de identificación',
            'value' => 100,
            'group_publicity_id'=>2,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en toldos, marquesinas y similares',
            'value' => 260,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en salas de cine y establecimientos o locales abiertos o cerrados a través de aparatos, proyectores, televisores, 
            , monitores y similares',
            'value' => 60,
            'group_publicity_id'=>1,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en vehículos y similares',
            'value' => 120,
            'group_publicity_id'=>3,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en los puestos de revistas, kioscos o similares',
            'value' => 20,
            'group_publicity_id'=>4,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Medios publicitarios combinados con servicio a la comunidad',
            'value' => 5,
            'group_publicity_id'=>2,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Vallas publicitarias',
            'value' => 70,
            'group_publicity_id'=>5,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Murales internos o externos',
            'value' => 50,
            'group_publicity_id'=>2,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Proyección de anuncios',
            'value' => 50,
            'group_publicity_id'=>2,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Pantallas o pizarras eléctricas o electrónicas',
            'value' => 60,
            'group_publicity_id'=>5,
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
