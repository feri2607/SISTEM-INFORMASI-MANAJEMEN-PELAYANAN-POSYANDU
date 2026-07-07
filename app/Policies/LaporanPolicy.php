<?php

namespace App\Policies;

use App\Models\User;

class LaporanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Determine whether the user can export pdf.
     */
    public function exportPdf(User $user): bool
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Determine whether the user can export excel.
     */
    public function exportExcel(User $user): bool
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Determine whether the user can view statistics.
     */
    public function viewStats(User $user): bool
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Restrict deletion
     */
    public function delete(User $user): bool
    {
        return false; // No one can delete a report manually (it's read-only)
    }
}
