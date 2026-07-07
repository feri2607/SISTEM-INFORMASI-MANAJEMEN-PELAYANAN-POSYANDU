<?php
// app/Policies/BalitaPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Balita;

class BalitaPolicy
{
    /**
     * Determine whether the user can view any balita.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the balita.
     */
    public function view(User $user, Balita $balita)
    {
        // Admin: bisa melihat semua
        if ($user->role === 'admin') {
            return true;
        }
        
        // Pegawai: bisa melihat semua balita
        if ($user->role === 'pegawai') {
            return true;
        }
        
        // Warga (role: user): hanya bisa melihat balita miliknya sendiri
        if ($user->role === 'user') {
            return $user->id === $balita->warga->user_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create balita.
     */
    public function create(User $user)
    {
        // Admin, Pegawai, dan Warga bisa membuat balita
        return in_array($user->role, ['admin', 'pegawai', 'user']);
    }

    /**
     * Determine whether the user can update the balita.
     * Warga hanya bisa update data identitas (nama, tgl lahir, dll) 
     * dan hanya jika belum diverifikasi.
     */
    public function update(User $user, Balita $balita)
    {
        // Admin: bisa update semua
        if ($user->role === 'admin') {
            return true;
        }
        
        // Pegawai: bisa update semua balita
        if ($user->role === 'pegawai') {
            return true;
        }
        
        // Warga: hanya bisa update balita miliknya sendiri dan belum diverifikasi
        if ($user->role === 'user') {
            return $user->id === $balita->warga->user_id && !$balita->is_verified;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the balita.
     * Warga hanya bisa menghapus balita miliknya sendiri dan belum diverifikasi.
     */
    public function delete(User $user, Balita $balita)
    {
        // Admin: bisa hapus semua
        if ($user->role === 'admin') {
            return true;
        }
        
        // Pegawai: bisa hapus semua balita
        if ($user->role === 'pegawai') {
            return true;
        }
        
        // Warga: hanya bisa hapus balita miliknya sendiri dan belum diverifikasi
        if ($user->role === 'user') {
            return $user->id === $balita->warga->user_id && !$balita->is_verified;
        }
        
        return false;
    }

    /**
     * Determine whether the user can view health data.
     * Semua user yang bisa view balita juga bisa view health data.
     */
    public function viewHealthData(User $user, Balita $balita)
    {
        return $this->view($user, $balita);
    }

    /**
     * Determine whether the user can update health data.
     * HANYA Admin dan Pegawai yang bisa mengupdate data kesehatan.
     * Warga TIDAK BISA mengubah data kesehatan (berat badan, tinggi badan, status gizi, dll).
     */
    public function updateHealthData(User $user, Balita $balita)
    {
        // Hanya admin dan pegawai yang bisa update data kesehatan
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Determine whether the user can verify balita.
     * HANYA Admin dan Pegawai yang bisa memverifikasi balita.
     */
    public function verify(User $user, Balita $balita)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}