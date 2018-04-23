<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private $activity;

    public function __construct(Activity $activity) {
        $this->activity = $activity;
    }

    public function index(Request $request)
    {
        $activities = $this->activity
        ->where('course_id', $request->get('course_id'))
        ->where('date_from', '>=', now()->toDateString())
        ->orderBy('date_from', 'asc')
        ->get();

        return response()->json($activities);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'course_id' => 'nullable|exists:courses,id',
            'venue' => 'required|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);
        
        $activity = $this->activity->firstOrCreate($request->all());

        return response()->json($activity);
    }

    public function update(Request $request, Activity $activity)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'course_id' => 'nullable|exists:courses,id',
            'venue' => 'required|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);
        
        $activity->update($request->all());

        return response()->json($activity);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        // add comments
    }
}
