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
<<<<<<< HEAD
            'value' => 300,
=======
            'value' => 45,
            'group_publicity_id'=>4,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad de folletos, hojas impresas, afiches o similares',
<<<<<<< HEAD
            'value' => 3500,
=======
            'value' => 125,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad encartada en los medios de comunicación impresos',
<<<<<<< HEAD
            'value' => 1500,
=======
            'value' => 125,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Afiches o similares',
<<<<<<< HEAD
            'value' => 1700,
=======
            'value' => 125,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en bonos, billetes, boletos, cupones y similares',
<<<<<<< HEAD
            'value' => 1500,
=======
            'value' => 125,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en prendas de vestir, articulos u objetos diversos',
<<<<<<< HEAD
            'value' => 1500,
=======
            'value' => 125,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad por medio de aviones, helicópteros, globos dirigibles o aerostáticos y medios similares',
<<<<<<< HEAD
            'value' => 2500,
=======
            'value' => 1000,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
            'name' => 'Publicidad por medio de globos fijos',
<<<<<<< HEAD
            'value' => 75,
=======
            'value' => 50,
            'group_publicity_id'=>1,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad por medio de megáfonos',
<<<<<<< HEAD
            'value' => 1500,
=======
            'value' => 75,
            'group_publicity_id'=>1,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en anuncios, avisos y similares',
<<<<<<< HEAD
            'value' => 700,
=======
            'value' => 60,
            'group_publicity_id'=>2,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Avisos de identificación',
<<<<<<< HEAD
            'value' => 1000,
=======
            'value' => 100,
            'group_publicity_id'=>2,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en toldos, marquesinas y similares',
<<<<<<< HEAD
            'value' => 1000,
=======
            'value' => 260,
            'group_publicity_id'=>3,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
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
<<<<<<< HEAD
            'value' => 2500,
=======
            'value' => 120,
            'group_publicity_id'=>4,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Publicidad en los puestos de revistas, kioscos o similares',
<<<<<<< HEAD
            'value' => 1500,
=======
            'value' => 20,
            'group_publicity_id'=>4,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Medios publicitarios combinados con servicio a la comunidad',
<<<<<<< HEAD
            'value' => 2000,
=======
            'value' => 5,
            'group_publicity_id'=>2,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Vallas publicitarias',
<<<<<<< HEAD
            'value' => 400,
=======
            'value' => 70,
            'group_publicity_id'=>5,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Murales internos o externos',
<<<<<<< HEAD
            'value' => 500,
=======
            'value' => 50,
            'group_publicity_id'=>2,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Proyección de anuncios',
<<<<<<< HEAD
            'value' => 2000,
=======
            'value' => 50,
            'group_publicity_id'=>2,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
        	'name' => 'Pantallas o pizarras eléctricas o electrónicas',
<<<<<<< HEAD
            'value' => 2000,
=======
            'value' => 60,
            'group_publicity_id'=>5,
>>>>>>> 062a1c0f28d9d02ea8a4c1e1eea03ae819f588b8
        	'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('advertising_type')->insert([
            'name' => 'Publicidad para cigarrillos o bebidas alcoholicas',
            'value' => 5000,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
