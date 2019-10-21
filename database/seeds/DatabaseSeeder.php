<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([CiuGroupTableSeeder::class,
                    CiuTableSeeder::class,
                    ParishTableSeeder::class,
                    UsersTableSeeder::class,
                    CompanyTableSeeder::class,
                    UsersCompanyTableSeeder::class,
                    CiuCompanyTableSeeder::class,
                    UnidTribuTableSeeder::class,
                    ExtrasTableSeeder::class,
                    EmployeesTableSeeder::class,
                    RolesTableSeeder::class,
                    RolPermissionTableSeeder::class,
                    PermissionsTableSeeder::class
        ]);
    }
}
