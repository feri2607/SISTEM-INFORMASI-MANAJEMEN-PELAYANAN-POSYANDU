<?php
// app/Policies/WargaPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Warga;

class WargaPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'user']);
    }

    public function view(User $user, Warga $warga)
    {
        // Admin & Pegawai: bisa melihat semua
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        
        // Warga (role: user): hanya bisa melihat data sendiri
        if ($user->role === 'user') {
            return $user->id === $warga->user_id;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai', 'user']);
    }

    public function update(User $user, Warga $warga)
    {
        // Admin & Pegawai: bisa update semua
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        
        // Warga (role: user): bisa update data sendiri
        if ($user->role === 'user') {
            return $user->id === $warga->user_id;
        }
        
        return false;
    }

    public function delete(User $user, Warga $warga)
    {
        // Admin & Pegawai: bisa hapus semua
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return true;
        }
        
        // Warga (role: user): bisa hapus data sendiri
        if ($user->role === 'user') {
            return $user->id === $warga->user_id;
        }
        
        return false;
    }

    public function verify(User $user, Warga $warga)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function reject(User $user, Warga $warga)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}