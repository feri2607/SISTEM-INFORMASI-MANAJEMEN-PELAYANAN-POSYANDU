<?php
// app/Policies/FaqPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Faq;

class FaqPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Faq $faq)
    {
        return $faq->status === 'published' || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Faq $faq)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Faq $faq)
    {
        return $user->role === 'admin';
    }

    public function publish(User $user, Faq $faq)
    {
        return $user->role === 'admin';
    }
}