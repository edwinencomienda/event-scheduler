<?php

namespace App\Http\Controllers;

use App\ExamSchedule;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    private $examSchedule;

    public function __construct(ExamSchedule $examSchedule) {
        $this->examSchedule = $examSchedule;
    }

    public function index()
    {
        return response()->json($this->examSchedule->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'proctor_id' => 'required|exists:users,id'
        ]);
        
        $examSchedule = $this->examSchedule->firstOrCreate($request->all());

        return response()->json($examSchedule);
    }

    public function update(Request $request, ExamSchedule $examSchedule)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'proctor_id' => 'required|exists:users,id'
        ]);
        
        $examSchedule->update($request->only(['examSchedule', 'school_year']));

        return response()->json($examSchedule);
    }

    public function destroy(ExamSchedule $examSchedule)
    {
        $examSchedule->delete();
    }
}
