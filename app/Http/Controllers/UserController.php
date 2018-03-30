<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
             'last_name' => 'required',
             'gender' => 'required',
             'email' => 'required|unique:users',
             'password' => 'required',
             'course_id' => 'required|exists:courses,id',
             'year_level' => 'required',
             'role' => 'required',
             'status' => 'required'
        ]);

        $user = User::create($request->only([
            'first_name',
             'last_name',
             'middle_name',
             'gender',
             'email',
             'password',
             'course_id',
             'year_level',
             'role',
             'status'
        ]));

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json('error.', 500);
        }
    }
}
