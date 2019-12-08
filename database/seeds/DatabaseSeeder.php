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
            ParishTableSeeder::class,
            UsersTableSeeder::class,
            CompanyTableSeeder::class,
            UsersCompanyTableSeeder::class,
            CiuCompanyTableSeeder::class,
            UnidTribuTableSeeder::class,
            ExtrasTableSeeder::class,
            EmployeesTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            CatastralTerrenoTableSeeder::class,
            CatastralConstruccionTableSeeder::class,
            AlicuotaTableSeeder::class,
        ]);
    }
}
