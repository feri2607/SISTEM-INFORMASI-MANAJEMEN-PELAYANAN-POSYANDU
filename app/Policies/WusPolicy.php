<?php
// app/Policies/WusPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Wus;

class WusPolicy
{
    public function view(User $user, Wus $wus)
    {
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        return in_array($user->role, ['warga', 'user']) && $wus->warga && $user->id === $wus->warga->user_id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'warga', 'user']);
    }

    public function update(User $user, Wus $wus)
    {
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        return in_array($user->role, ['warga', 'user']) && $wus->warga && $user->id === $wus->warga->user_id && !$wus->is_verified;
    }

    public function delete(User $user, Wus $wus)
    {
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        return in_array($user->role, ['warga', 'user']) && $wus->warga && $user->id === $wus->warga->user_id && !$wus->is_verified;
    }

    public function updateHealthData(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}