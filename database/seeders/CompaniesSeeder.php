<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'PT. Sagara Xinix Solusitama',
                'location' => 'Jl. Mampang Prapatan Raya 108 Rukan Buncit Mas, Blok C3A, Lantai 2-4, Daerah Khusus Ibukota Jakarta 12760',
                'description' => 'PT. Sagara Xinix Solusitama is a dynamic company with a fresh view on Information Technology. Deliver business-driven technology for your company is most paramount thing to us. Our entire organization is geared towards building high quality solutions for our clients.'
            ],
            [
                'name' => 'Esa Unggul University',
                'location' => 'Jl. Arjuna Utara No.9, Kb. Jeruk, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11510',
                'description' => 'Esa Unggul is a university which have many faculities. some of them is faculities of faculity of computer science, faculity of law, faculity of business, etc.'
            ]
        ];

        DB::table('companies')->insert($data);
    }
}
