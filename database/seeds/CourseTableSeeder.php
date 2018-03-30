<?php

use App\Course;
use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = ['BSIT', 'BSED', 'BSFT'];
        foreach ($courses as $course) {
            Course::firstOrCreate([
                'name' => $course
            ]);
        }
    }
}
