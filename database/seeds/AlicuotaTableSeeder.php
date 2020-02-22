<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlicuotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Construidos',
            'status'=> 'enabled',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios',
            'status'=> 'enabled',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios Ociosos',
            'status'=> 'enabled',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Construcciones',
            'status'=> 'enabled',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('timeline_alicuota')->insert([
            'since' => '2020-01-01',
            'to' => '2020-12-31',
            'value' => 0.01,
            'alicuota_inmueble_id' => 1
        ]);

        DB::table('timeline_alicuota')->insert([
            'since' => '2020-01-01',
            'to' => '2020-12-31',
            'value' => 0.01,
            'alicuota_inmueble_id' => 2
        ]);

        DB::table('timeline_alicuota')->insert([
            'since' => '2020-01-01',
            'to' => '2020-12-31',
            'value' => 0.03,
            'alicuota_inmueble_id' => 3
        ]);

        DB::table('timeline_alicuota')->insert([
            'since' => '2020-01-01',
            'to' => '2020-12-31',
            'value' => 0.01,
            'alicuota_inmueble_id' => 4
        ]);
    }
}
