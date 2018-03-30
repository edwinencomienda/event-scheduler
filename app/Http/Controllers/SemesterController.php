<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    private $semester;

    public function __construct(Semester $semester) {
        $this->semester = $semester;
    }

    public function index()
    {
        return response()->json($this->semester->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'semester' => 'required|integer',
            'school_year' => 'required|string'
        ]);
        
        $semester = $this->semester->firstOrCreate($request->only(['semester', 'school_year']));

        return response()->json($semester);
    }

    public function update(Request $request, Semester $semester)
    {
        $this->validate($request, [
            'semester' => 'required|integer',
            'school_year' => 'required|string'
        ]);
        
        $semester->update($request->only(['semester', 'school_year']));

        return response()->json($semester);
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
    }
}
