<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
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
                'name' => 'PHP',
                'description' => 'PHP Programing Language'
            ],
            [
                'name' => 'JavaScript',
                'description' => 'JavaScript Programing Language',
            ],
            [
                'name' => 'Python',
                'description' => 'Python Programing Languange',
            ],
            [
                'name' => 'Laravel',
                'description' => 'PHP web framework',
            ],
            [
                'name' => 'React',
                'description' => 'JavaScript Library for Build Web Front End',
            ]
        ];

        DB::table('skills')->insert($data);
    }
}
