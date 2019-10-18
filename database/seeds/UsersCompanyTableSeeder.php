<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UsersCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
<<<<<<< HEAD
        DB::table('users')->insert([
            'user_id'=>2,
=======
        DB::table('users_company')->insert([
            'user_id'=>1,
>>>>>>> c8b10c26596fed77e04f576eb00c455f898aea6c
            'company_id'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
