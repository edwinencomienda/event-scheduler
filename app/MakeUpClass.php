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

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
