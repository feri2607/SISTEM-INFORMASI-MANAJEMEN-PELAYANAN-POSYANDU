<?php
// app/Policies/ContactPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactMessage;

class ContactPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Contact $contact)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Contact $contact)
    {
        return $user->role === 'admin';
    }

    public function viewMessage(User $user, ContactMessage $message)
    {
        return $user->role === 'admin';
    }

    public function deleteMessage(User $user, ContactMessage $message)
    {
        return $user->role === 'admin';
    }

    public function updateMessage(User $user, ContactMessage $message)
    {
        return $user->role === 'admin';
    }
}