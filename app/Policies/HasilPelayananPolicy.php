<?php

namespace App\Policies;

use App\Models\HasilPelayanan;
use App\Models\User;

class HasilPelayananPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HasilPelayanan $pelayanan): bool
    {
        return $user->role === 'admin'
            || $user->role === 'pegawai'
            || $user->id === $pelayanan->user_id
            || $user->id === ($pelayanan->balita?->warga?->user_id);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, HasilPelayanan $pelayanan): bool
    {
        return $user->role === 'admin'
            || $user->role === 'pegawai'
            || $user->id === $pelayanan->user_id
            || $user->id === ($pelayanan->balita?->warga?->user_id);
    }

    public function delete(User $user, HasilPelayanan $pelayanan): bool
    {
        return $user->role === 'admin'
            || $user->role === 'pegawai'
            || $user->id === $pelayanan->user_id
            || $user->id === ($pelayanan->balita?->warga?->user_id);
    }
}
