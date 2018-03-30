<?php

namespace App\Http\Controllers;

use App\UserSubject;
use Illuminate\Http\Request;

class UserSubjectController extends Controller
{
    private $userSubject;

    public function __construct(UserSubject $userSubject) {
        $this->userSubject = $userSubject;
    }

    public function index()
    {
        return response()->json($this->userSubject->all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'section_id' => 'required|exists:sections,id'
        ]);
        
        $userSubject = $this->userSubject->firstOrCreate($request->all());

        return response()->json($userSubject);
    }

    public function update(Request $request, UserSubject $userSubject)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'section_id' => 'required|exists:sections,id'
        ]);
        
        $userSubject->update($request->all());

        return response()->json($userSubject);
    }

    public function destroy(UserSubject $userSubject)
    {
        $userSubject->delete();
    }
}
