<?php
// app/Policies/KegiatanPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\KegiatanPosyandu;

class KegiatanPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, KegiatanPosyandu $kegiatan)
    {
        return $user->role === 'admin' || $user->id === $kegiatan->user_id;
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, KegiatanPosyandu $kegiatan)
    {
        return $user->role === 'admin' || $user->id === $kegiatan->user_id;
    }

    public function delete(User $user, KegiatanPosyandu $kegiatan)
    {
        return $user->role === 'admin' || $user->id === $kegiatan->user_id;
    }

    public function updateStatus(User $user, KegiatanPosyandu $kegiatan)
    {
        return $user->role === 'admin' || $user->id === $kegiatan->user_id;
    }

    public function export(User $user)
    {
        return $user->role === 'admin';
    }
}