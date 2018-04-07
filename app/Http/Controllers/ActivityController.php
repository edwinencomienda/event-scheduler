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
        if ($request->has('upcoming')) {
            $activities = $this->activity
            ->where('course_id', $request->get('course_id'))
            ->orderBy('date_from')
            ->latest()->get();
        } else {
            $activities = $this->activity->latest()->get();
        }
        
        return response()->json($activities);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'course_id' => 'nullable|exists:courses,id',
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
            'course_id' => 'nullable|exists:courses,id'
        ]);
        
        $activity->update($request->all());

        return response()->json($activity);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
    }
}
