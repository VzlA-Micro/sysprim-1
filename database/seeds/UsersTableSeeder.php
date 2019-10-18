<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'ci'=>'V30000000',
            'name'=>'Sysprim',
            'surname'=>'Sysprim',
            'phone'=>'04141234567',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'role_id'=>null,
            'email'=>'sysprim@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'CALLE 12 CARRERA 2',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
