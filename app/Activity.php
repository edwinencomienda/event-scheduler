<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'date',
        'time_start',
        'time_end',
        'course_id'
    ];
}
