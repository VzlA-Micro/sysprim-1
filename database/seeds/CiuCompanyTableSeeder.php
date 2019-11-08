<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CiuCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('company_ciu')->insert([
            'ciu_id'=>6,
            'company_id'=>1,
        ]);


        DB::table('company_ciu')->insert([
            'ciu_id'=>7,
            'company_id'=>1,

        ]);

    }
}
