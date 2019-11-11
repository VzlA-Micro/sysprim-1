<?php

use Illuminate\Database\Seeder;

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
            'value_edificacion'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios',
            'value_edificacion'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Terrenos Vacios Ociosos',
            'value_edificacion'=>0.03,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('alicuota_inmueble')->insert([
            'name'=>'Construcciones',
            'value_edificacion'=>0.01,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
