<?php
// app/Http/Requests/LansiaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LansiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $lansiaId = $this->route('lansia')?->id;

        return [
            'nama'            => ['required', 'string', 'max:255'],
            'nik'             => ['required', 'string', 'size:16', 'unique:lansia,nik,' . $lansiaId],
            'tanggal_lahir'   => ['required', 'date', 'before:-60 years'],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'alamat'          => ['required', 'string', 'max:500'],
            'golongan_darah'  => ['nullable', 'in:A,B,AB,O'],
            'no_hp'           => ['nullable', 'string', 'max:20'],
            'riwayat_penyakit'=> ['nullable', 'string', 'max:1000'],
            'foto'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama wajib diisi.',
            'nik.required'           => 'NIK wajib diisi.',
            'nik.size'               => 'NIK harus 16 digit.',
            'nik.unique'             => 'NIK sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before'   => 'Usia minimal 60 tahun untuk Posyandu Lansia.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'foto.image'             => 'File harus berupa gambar.',
            'foto.max'               => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
