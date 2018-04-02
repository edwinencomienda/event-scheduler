<?php

use App\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::create([
            'semester' => 1,
            'school_year' => '2017-2018'
        ]);

        Semester::create([
            'semester' => 2,
            'school_year' => '2017-2018'
        ]);
    }
}
