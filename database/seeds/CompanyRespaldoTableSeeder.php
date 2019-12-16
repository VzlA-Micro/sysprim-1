<?php

use Illuminate\Database\Seeder;

class CompanyRespaldoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/register/register_company.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
