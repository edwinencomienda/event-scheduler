<?php

namespace App\Http\Controllers;

use App\MakeUpClass;
use Illuminate\Http\Request;

class MakeUpClassController extends Controller
{
    private $makeUpClass;

    public function __construct(MakeUpClass $makeUpClass) {
        $this->makeUpClass = $makeUpClass;
    }

    public function index()
    {
        return response()->json($this->makeUpClass->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date_format:Y-m-d',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);
        
        $makeUpClass = $this->makeUpClass->firstOrCreate($request->all());

        return response()->json($makeUpClass);
    }

    public function update(Request $request, MakeUpClass $makeUpClass)
    {
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);
        
        $makeUpClass->update($request->all());

        return response()->json($makeUpClass);
    }

    public function destroy(MakeUpClass $makeUpClass)
    {
        $makeUpClass->delete();
    }
}
