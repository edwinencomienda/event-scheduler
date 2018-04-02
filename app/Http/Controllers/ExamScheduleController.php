<?php

namespace App\Http\Controllers;

use App\ExamSchedule;
use Illuminate\Http\Request;
use App\Rules\ExamScheduleIsAvailable;
use App\Http\Requests\ExamSchedule\StoreRequest;

class ExamScheduleController extends Controller
{
    private $examSchedule;

    public function __construct(ExamSchedule $examSchedule) {
        $this->examSchedule = $examSchedule;
    }

    public function index(Request $request)
    {
        $examSchedules = $this->examSchedule->with([
            'subject',
            'proctor',
            'room',
            'section'
        ])->get();
        return response()->json($examSchedules);
    }

    public function store(StoreRequest $request)
    {
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
        
        $examSchedule->update($request->all());

        return response()->json($examSchedule);
    }

    public function destroy(ExamSchedule $examSchedule)
    {
        $examSchedule->delete();
    }
}
