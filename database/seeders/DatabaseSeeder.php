<?php

namespace Database\Seeders;

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
        $this->call([
            SqlCountriesSeeder::class,
            UsersTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            CompaniesSeeder::class,
            SkillsSeeder::class,
            JobsSeeder::class,
        ]);
    }
}
