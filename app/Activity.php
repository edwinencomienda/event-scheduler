<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'date',
        'date_from',
        'date_to',
        'course_id',
        'description'
    ];
}
