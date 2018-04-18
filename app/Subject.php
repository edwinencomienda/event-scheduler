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

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }
}
