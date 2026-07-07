<?php
// app/Http/Requests/Profile/DeleteAccountRequest.php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password'],
            'confirmation' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password wajib diisi untuk konfirmasi.',
            'password.current_password' => 'Password tidak sesuai.',
            'confirmation.required' => 'Anda harus menyetujui untuk menghapus akun.',
            'confirmation.accepted' => 'Anda harus menyetujui untuk menghapus akun.',
        ];
    }
}