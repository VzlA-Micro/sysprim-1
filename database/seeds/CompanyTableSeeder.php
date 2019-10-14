<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('company')->insert([
            'name'=>'JMSoft',
            'RIF'=>'J43443344',
            'code_catastral'=>12345678998765432100,
            'license'=>'L000020758',
            'opening_date'=>'2019-9-01',
            'lat'=>55,
            'lng'=>578,
            'address'=>'CARRERA 25 ENTRE CALLES 9 Y 10, N°9-181',
            'number_employees'=>50,
            'sector'=>'norte',
            'phone'=>2515125665,
            'image'=>null,
            'parish_id'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
