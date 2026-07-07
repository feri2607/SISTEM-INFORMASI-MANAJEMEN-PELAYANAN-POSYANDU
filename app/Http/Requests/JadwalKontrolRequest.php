<?php
// app/Http/Requests/JadwalKontrolRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalKontrolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wus_id' => ['required', 'exists:wus,id'],
            'tanggal' => ['required', 'date', 'after:today'],
            'jam' => ['required', 'date_format:H:i'],
            'lokasi' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'wus_id.required' => 'WUS wajib dipilih.',
            'wus_id.exists' => 'WUS tidak valid.',
            'tanggal.required' => 'Tanggal kontrol wajib diisi.',
            'tanggal.after' => 'Tanggal kontrol harus setelah hari ini.',
            'jam.required' => 'Jam kontrol wajib diisi.',
            'jam.date_format' => 'Format jam tidak valid.',
            'lokasi.required' => 'Lokasi kontrol wajib diisi.',
        ];
    }
}