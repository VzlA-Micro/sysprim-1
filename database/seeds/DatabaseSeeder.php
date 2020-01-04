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
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersTableSeeder::class,
            ParishTableSeeder::class,
            CompanyTableSeeder::class,
            UsersCompanyTableSeeder::class,
            CiuCompanyTableSeeder::class,
            UnidTribuTableSeeder::class,
            EmployeesTableSeeder::class,
            CatastralTerrenoTableSeeder::class,
            CatastralConstruccionTableSeeder::class,
            AlicuotaTableSeeder::class,
            FinesTableSeeder::class,
            CompanyRespaldoTableSeeder::class,
            AdvertisingTypeTableSeeder::class
        ]);
    }
}
