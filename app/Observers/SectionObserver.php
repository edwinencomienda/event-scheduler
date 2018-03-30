<?php

namespace App\Observers;

use App\Course;
use App\Section;

class SectionObserver
{
    protected static $lookup = [
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I',
    ];

    public function saving(Section $section)
    {
        $course = Course::find($section->course_id);
        $section->code = $course->name . ' ' . $this->toRomanNumeral($section->year_level) . '-' . strtoupper($section->section);
        $section->section = strtoupper($section->section);
    }

    public function toRomanNumeral($number)
    {
        $solution = '';
        foreach(static::$lookup as $limit => $glyph){
            while ($number >= $limit) {
                $solution .= $glyph;
                $number -= $limit;
            }
        }
        return $solution;
    }
}
