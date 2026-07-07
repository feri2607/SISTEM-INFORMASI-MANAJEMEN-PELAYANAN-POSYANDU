<?php
// app/Policies/AnnouncementPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Announcement;

class AnnouncementPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Announcement $announcement)
    {
        if ($announcement->status !== 'published') {
            return in_array($user->role, ['admin', 'pegawai']);
        }
        if ($announcement->publish_at && $announcement->publish_at > now()) {
            return in_array($user->role, ['admin', 'pegawai']);
        }
        return true;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function update(User $user, Announcement $announcement)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function delete(User $user, Announcement $announcement)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function publish(User $user, Announcement $announcement)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}