<?php
// app/Policies/ArticlePolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Article $article)
    {
        return $article->status === 'published' || in_array($user->role, ['admin', 'pegawai']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function update(User $user, Article $article)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function delete(User $user, Article $article)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }

    public function publish(User $user, Article $article)
    {
        return in_array($user->role, ['admin', 'pegawai']);
    }
}