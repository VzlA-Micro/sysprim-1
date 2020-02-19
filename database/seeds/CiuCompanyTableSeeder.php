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
        $path = base_path().'/database/seeds/register/ciu.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $path = base_path().'/database/seeds/register/timeline_ciu.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);




        DB::table('company_ciu')->insert([
            'ciu_id'=>6,
            'company_id'=>1,
        ]);

        DB::table('company_ciu')->insert([
            'ciu_id'=>4,
            'company_id'=>1,
        ]);

    }
}
