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
        ]);
        
        if ($request->has('subject_id')) {
            $examSchedules->where('subject_id', $request->get('subject_id'));
        }
        if ($request->has('proctor_id')) {
            $examSchedules->where('proctor_id', $request->get('proctor_id'));
        }
        if ($request->has('section_id')) {
            $examSchedules->where('section_id', $request->get('section_id'));
        }

        $examSchedules = $examSchedules->get();
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
            'proctor_id' => 'required|exists:users,id',
            'term' => 'required',
            'day' => 'required',
            'school_year' => 'required',
            'semester' => 'semester'
        ]);
        
        $examSchedule->update($request->all());

        return response()->json($examSchedule);
    }

    public function destroy(ExamSchedule $examSchedule)
    {
        $examSchedule->delete();
    }
}
