<?php
// app/Policies/RemajaPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Remaja;

class RemajaPolicy
{
    public function view(User $user, Remaja $remaja)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return ($user->role === 'warga' || $user->role === 'user') && $user->id === $remaja->warga->user_id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'warga', 'user']);
    }

    public function update(User $user, Remaja $remaja)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return ($user->role === 'warga' || $user->role === 'user') && $user->id === $remaja->warga->user_id && !$remaja->is_verified;
    }

    public function delete(User $user, Remaja $remaja)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return ($user->role === 'warga' || $user->role === 'user') && $user->id === $remaja->warga->user_id && !$remaja->is_verified;
    }

    public function updateHealthData(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}