<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakeUpClass extends Model
{
    protected $fillable = [
        'subject_id',
        'date',
        'time_start',
        'time_end'
    ];
}
