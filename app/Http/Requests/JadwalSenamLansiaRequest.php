<?php
// app/Http/Requests/JadwalSenamLansiaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JadwalSenamLansiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'pegawai']);
    }

    public function rules(): array
    {
        return [
            'tanggal'    => ['required', 'date'],
            'jam'        => ['required', 'date_format:H:i'],
            'lokasi'     => ['required', 'string', 'max:255'],
            'instruktur' => ['nullable', 'string', 'max:255'],
            'kuota'      => ['required', 'integer', 'min:1', 'max:500'],
            'status'     => ['required', 'in:aktif,selesai,dibatalkan'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required'    => 'Tanggal jadwal wajib diisi.',
            'jam.required'        => 'Jam jadwal wajib diisi.',
            'jam.date_format'     => 'Format jam tidak valid (HH:MM).',
            'lokasi.required'     => 'Lokasi wajib diisi.',
            'kuota.required'      => 'Kuota peserta wajib diisi.',
            'kuota.min'           => 'Kuota minimal 1 peserta.',
            'status.required'     => 'Status jadwal wajib dipilih.',
        ];
    }
}
