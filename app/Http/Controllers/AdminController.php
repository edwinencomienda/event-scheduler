<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function approveUserRequest(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id'
        ]); 

        $this->user->find($request->get('user_id'))
        ->update([
            'active' => true
        ]);
    }
}
