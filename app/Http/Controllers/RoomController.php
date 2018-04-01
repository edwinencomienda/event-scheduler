<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $room;

    public function __construct(Room $room) {
        $this->room = $room;
    }

    public function index()
    {
        return response()->json($this->room->all());
    }
}
