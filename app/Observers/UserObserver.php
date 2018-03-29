<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function saving(User $user)
    {
        $user->name = $user->first_name . ' ' . $user->last_name;
    }
}
