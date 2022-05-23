<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
            [
                [
                    'first_name' => "Super",
                    'last_name' => "Administrator",
                    'username' => 'superadmin',
                    'email' => 'superadmin@sagara.id',
                    'password' => bcrypt('password'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'religion' => 'hidden',
                    'phone' => '02179170400',
                    'country_id' => 1,
                    'province_id' => 11,
                    'city_id' => 155,
                    'residence' => 'Jl. Mampang Prapatan Raya 108 Rukan Buncit Mas, Blok C3A, Lantai 2-4, Daerah Khusus Ibukota Jakarta 12760',
                    'dob' => '2010-01-01',
                ],
            ];

        DB::table('users')->insert($users);
    }
}
