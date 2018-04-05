<?php

namespace App\Http\Controllers;

use App\User;
use App\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $user;

    public function __construct(user $user) {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $users = $this->user->with([
            'course',
            'subjects',
        ]);

        if ($request->has('inactive')) {
            $users->where('active', 0);
        }

        if ($request->has('role')) {
            $users->where('role', $request->get('role'));
        }

        $users = $users->get();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
             'first_name' => 'required',
             'last_name' => 'required',
             'email' => 'required|unique:users',
             'password' => 'required',
             'role' => 'required',
             'gender' => 'required',
             'active' => '1'
        ]);

        $request['password'] = bcrypt($request['password']);

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

    public function show(User $user)
    {
        $user->subjects;
        $user->course;
        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::where('email', $email)
        ->with('subjects.subject')
        ->first();

        if (!$user) {
            return response()->json('email and password is incorrect.', 404);
        }

        if (Hash::check($password, $user->password)) {
            // The passwords match...
            return response()->json($user, 200);
        } else {
            return response()->json('password not match.', 404);
        }
    }

    public function changePassword(Request $request)
    {
        $email = $request->get('email');
        $old_password = $request->get('old_password');
        $new_password = $request->get('new_password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json('account not found.', 404);
        }

        if (Hash::check($old_password, $user->password)) {
            // The passwords match...
            $user->update([
                'password' => bcrypt($new_password)
            ]);
            return response()->json($user, 200);
        } else {
            return response()->json('old password not match.', 404);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    public function userExamSchedules($id)
    {
        $user = User::find($id);
        $subjectIds = collect($user->subjects)->pluck('subject_id');
        return ExamSchedule::with('subject', 'proctor')
        ->whereIn('subject_id', $subjectIds)
        ->get();
    }
}
