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
            'value'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios',
            'value'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios Ociosos',
            'value'=>0.03,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Construcciones',
            'value'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
