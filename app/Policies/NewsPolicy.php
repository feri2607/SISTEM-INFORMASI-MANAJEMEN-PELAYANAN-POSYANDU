<?php
// app/Policies/NewsPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\News;

class NewsPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, News $news)
    {
        return $news->status === 'published' || in_array($user->role, ['admin', 'pegawai']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function update(User $user, News $news)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function delete(User $user, News $news)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function publish(User $user, News $news)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}