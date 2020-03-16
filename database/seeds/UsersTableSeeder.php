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
            'email'=>'sysprim@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'CALLE 12 CARRERA 2',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'role_id'=>1,
        ]);

        DB::table('users')->insert([
            'ci'=>'V12345678',
            'name'=>'Ticket',
            'surname'=>'Office',
            'phone'=>'04121234567',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'email'=>'ticket.office@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'CALLE 12 CARRERA 2',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'role_id'=>2,
        ]);

        DB::table('users')->insert([
            'ci'=>'V9876321',
            'name'=>'usuario',
            'surname'=>'Sysprim',
            'phone'=>'04121234567',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'email'=>'jhonbeiker.ma26@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'CALLE 12 CARRERA 2',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'role_id'=>3,
        ]);

       

        DB::table('users')->insert([
            'ci'=>'V14141478',
            'name'=>'Admin',
            'surname'=>'Semat',
            'phone'=>'04121234567',
            'confirmed'=>1,
            'confirmed_code'=>null,
            'email'=>'admin@gmail.com',
            'email_verified_at'=>null,
            'password'=>Hash::make('Sysprim2000'),
            'address'=>'CALLE 12 CARRERA 2',
            'image'=>null,
            'remember_token'=>null,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'role_id'=>3,
        ]);

        
    }
}
