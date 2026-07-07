<?php
// app/Policies/KehamilanPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Kehamilan;

class KehamilanPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Kehamilan $kehamilan)
    {
        if ($user->role === 'admin') {
            return true;
        }
        
        if ($user->role === 'pegawai') {
            return true;
        }
        
        if (in_array($user->role, ['warga', 'user'])) {
            return $user->id === $kehamilan->warga->user_id;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'warga']);
    }

    public function update(User $user, Kehamilan $kehamilan)
    {
        if ($user->role === 'admin') {
            return true;
        }
        
        if ($user->role === 'pegawai') {
            return true;
        }
        
        // Warga hanya bisa update data identitas kehamilan
        if (in_array($user->role, ['warga', 'user'])) {
            return $user->id === $kehamilan->warga->user_id;
        }
        
        return false;
    }

    public function delete(User $user, Kehamilan $kehamilan)
    {
        if ($user->role === 'admin') {
            return true;
        }
        
        if ($user->role === 'pegawai') {
            return true;
        }
        
        return false;
    }

    public function updateHealthData(User $user, Kehamilan $kehamilan)
    {
        // Hanya admin dan pegawai yang bisa update data kesehatan kehamilan
        return in_array($user->role, ['admin', 'pegawai']);
    }
}