<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'description',
        'time_start',
        'time_end',
        'day_code',
        'room_id',
        'section',
        'is_lab',
        'units',
        'section_id',
        'instructor_id'
    ];
}
