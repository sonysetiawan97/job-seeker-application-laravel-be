<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsSeeder extends Seeder
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
                'title' => 'Pekerjaan 1',
                'company_id' => 1,
                'work_location' => 'hybrid',
                'work_level' => 'entry',
                'education_level' => 's1',
                'description' => 'description',
                'still_hiring' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Pekerjaan 2',
                'company_id' => 1,
                'work_location' => 'hybrid',
                'work_level' => 'entry',
                'education_level' => 's1',
                'description' => 'description',
                'still_hiring' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Pekerjaan 3',
                'company_id' => 1,
                'work_location' => 'hybrid',
                'work_level' => 'entry',
                'education_level' => 's1',
                'description' => 'description',
                'still_hiring' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('jobs')->insert($data);
    }
}
