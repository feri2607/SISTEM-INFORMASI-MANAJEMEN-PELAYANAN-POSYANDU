<?php
// app/Policies/LansiaPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Lansia;

class LansiaPolicy
{
    public function view(User $user, Lansia $lansia)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return $user->role === 'warga' && $user->id === $lansia->warga->user_id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'warga']);
    }

    public function update(User $user, Lansia $lansia)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return $user->role === 'warga' && $user->id === $lansia->warga->user_id && !$lansia->is_verified;
    }

    public function delete(User $user, Lansia $lansia)
    {
        if ($user->role === 'admin' || $user->role === 'pegawai') {
            return true;
        }
        return $user->role === 'warga' && $user->id === $lansia->warga->user_id && !$lansia->is_verified;
    }

    public function updateHealthData(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}