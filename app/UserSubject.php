<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'semester_id',
        'section_id'
    ];
}
