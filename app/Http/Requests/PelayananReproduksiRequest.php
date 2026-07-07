<?php
// app/Http/Requests/PelayananReproduksiRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PelayananReproduksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wus_id' => ['required', 'exists:wus,id'],
            'tanggal' => ['required', 'date'],
            'jenis_pelayanan' => ['required', Rule::in(['konsultasi', 'pemasangan_kb', 'kontrol', 'skrining', 'konseling'])],
            'jenis_kontrasepsi' => ['nullable', Rule::in(['pil', 'suntik', 'iud', 'implan', 'kondom', 'mow', 'mop'])],
            'hasil_pemeriksaan' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
            'jadwal_kontrol_berikutnya' => ['nullable', 'date', 'after:today'],
            'jam_kontrol' => ['nullable', 'date_format:H:i'],
            'lokasi_kontrol' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'wus_id.required' => 'WUS wajib dipilih.',
            'wus_id.exists' => 'WUS tidak valid.',
            'tanggal.required' => 'Tanggal pelayanan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jenis_pelayanan.required' => 'Jenis pelayanan wajib dipilih.',
            'jenis_pelayanan.in' => 'Jenis pelayanan tidak valid.',
            'jenis_kontrasepsi.in' => 'Jenis kontrasepsi tidak valid.',
            'jadwal_kontrol_berikutnya.after' => 'Jadwal kontrol harus setelah hari ini.',
            'jam_kontrol.date_format' => 'Format jam tidak valid.',
        ];
    }
}