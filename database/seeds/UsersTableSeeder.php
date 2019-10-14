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
        //
        DB::table('users')->insert([
            'ci'=>'V-27317921',
            'name'=>'Jhon',
            'surname'=>'Moran',
            'phone'=>'+584263073306',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'role_id'=>null,
            'email'=>'jhonbeiker26@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Jhon2000'),
            'address'=>'Av la cruz entre calle 6 y 7',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('users')->insert([
            'ci'=>'V-27317922',
            'name'=>'Sysprim',
            'surname'=>'Sysprim',
            'phone'=>'+584263073306',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'role_id'=>null,
            'email'=>'sysprim@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'en algun lugar del mundo',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
