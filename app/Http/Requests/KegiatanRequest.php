<?php
// app/Http/Requests/KegiatanRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kegiatan = $this->route('kegiatan');

        return [
            'nama_kegiatan' => ['required', 'string', 'min:5', 'max:255'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['terjadwal', 'berlangsung', 'selesai', 'dibatalkan'])],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.min' => 'Nama kegiatan minimal 5 karakter.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',

            'tanggal.required' => 'Tanggal pelaksanaan wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',

            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',

            'status.required' => 'Status kegiatan wajib dipilih.',
            'status.in' => 'Status kegiatan tidak valid.',
        ];
    }
}