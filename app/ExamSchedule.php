<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'subject_id',
        'date',
        'time_start',
        'time_end',
        'proctor_id'
    ];
}
