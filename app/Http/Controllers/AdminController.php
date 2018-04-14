<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
        // this is the a comment
    }

    public function approveUserRequest(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id'
        ]); 

        $user = $this->user->find($request->get('user_id'));
        $user->active = true;
        $user->save();

        return $user;
    }
}
