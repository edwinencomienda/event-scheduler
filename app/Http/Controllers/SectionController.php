<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private $section;

    public function __construct(Section $section) {
        $this->section = $section;
    }

    public function index()
    {
        return response()->json($this->section->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'section' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|integer'
        ]);
        
        $section = $this->section->firstOrCreate($request->only(['section', 'course_id', 'year_level']));

        return response()->json($section);
    }

    public function update(Request $request, Section $section)
    {
        $this->validate($request, [
            'section' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required|integer'
        ]);
        
        $section->update($request->only(['section', 'course_id', 'year_level']));

        return response()->json($section);
    }

    public function destroy(Section $section)
    {
        $section->delete();
    }
}
