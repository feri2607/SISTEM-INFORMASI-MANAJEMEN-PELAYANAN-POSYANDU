<?php
// app/Policies/ProfilePolicy.php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{
    public function view(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        return true;
    }

    public function delete(User $user)
    {
        return true;
    }
}