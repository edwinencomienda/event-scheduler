<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'code',
        'course_id',
        'year_level',
        'section'
    ];
}
