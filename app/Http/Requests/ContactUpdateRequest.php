<?php
// app/Http/Requests/ContactUpdateRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
            'google_maps_url' => ['nullable', 'string'],
            'office_hours' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'hero_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Posyandu wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format website tidak valid.',
            'facebook.url' => 'Format URL Facebook tidak valid.',
            'instagram.url' => 'Format URL Instagram tidak valid.',
            'youtube.url' => 'Format URL YouTube tidak valid.',
            'tiktok.url' => 'Format URL TikTok tidak valid.',
            'office_hours.required' => 'Jam operasional wajib diisi.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, atau webp.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'hero_image.image' => 'File hero image harus berupa gambar.',
            'hero_image.mimes' => 'Format hero image harus jpeg, png, jpg, atau webp.',
            'hero_image.max' => 'Ukuran hero image maksimal 2 MB.',
        ];
    }
}