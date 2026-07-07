<?php
// app/Policies/UserPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, User $model)
    {
        return $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, User $model)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, User $model)
    {
        // Admin cannot delete themselves
        return $user->role === 'admin' && $user->id !== $model->id;
    }

    public function updateRole(User $user, User $model)
    {
        return $user->role === 'admin' && $user->id !== $model->id;
    }
}