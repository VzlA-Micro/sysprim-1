<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_permissions')->insert([
        'role_id'=>1,
        'permission_id'=>1,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),
        ]);

        DB::table('roles_permissions')->insert([
            'role_id'=>2,
            'permission_id'=>2,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
