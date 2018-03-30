<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subject;

    public function __construct(Subject $subject) {
        $this->subject = $subject;
    }

    public function index()
    {
        return response()->json($this->subject->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string',
            'description' => 'required|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'day_code' => 'required|string',
            'room' => 'required|string',
            'is_lab' => 'required',
            'units' => 'required',
            'section_id' => 'required|exists:sections,id',
            'instructor_id' => 'required|exists:users,id'
        ]);

        $subject = $this->subject->firstOrCreate($request->all());

        return response()->json($subject);
    }

    public function update(Request $request, Subject $subject)
    {
        $this->validate($request, [
            'code' => 'required|string',
            'description' => 'required|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'day_code' => 'required|string',
            'room' => 'required|string',
            'is_lab' => 'required',
            'units' => 'required',
            'section_id' => 'required|exists:sections,id',
            'instructor_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ]);
        
        $subject->update($request->all());

        return response()->json($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
    }
}
