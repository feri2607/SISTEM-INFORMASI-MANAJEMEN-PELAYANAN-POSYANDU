<?php
// app/Http/Requests/Profile/UpdatePreferencesRequest.php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'theme' => ['nullable', 'in:light,dark,system'],
            'language' => ['nullable', 'in:id,en'],
            'email_notification' => ['nullable', 'boolean'],
            'jadwal_notification' => ['nullable', 'boolean'],
            'pengumuman_notification' => ['nullable', 'boolean'],
            'artikel_notification' => ['nullable', 'boolean'],
        ];
    }
}