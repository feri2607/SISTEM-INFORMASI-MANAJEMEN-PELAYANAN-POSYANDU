<?php
// app/Http/Requests/KehamilanRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KehamilanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'nama'             => ['required', 'string', 'max:255'],
            'nik'              => ['required', 'string', 'size:16'],
            'tanggal_lahir'    => ['required', 'date', 'before:today'],
            'hpht'             => ['required', 'date', 'before_or_equal:today'],
            'kehamilan_ke'     => ['required', 'integer', 'min:1', 'max:20'],
            'golongan_darah'   => ['nullable', 'in:A,B,AB,O'],
            'no_hp'            => ['nullable', 'string', 'max:20'],
            'alamat'           => ['nullable', 'string', 'max:1000'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:1000'],
            'riwayat_alergi'   => ['nullable', 'string', 'max:1000'],
            'foto'             => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama ibu wajib diisi.',
            'nik.required'           => 'NIK wajib diisi.',
            'nik.size'               => 'NIK harus 16 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'hpht.required'          => 'HPHT wajib diisi untuk menghitung HPL.',
            'hpht.before_or_equal'   => 'HPHT tidak boleh di masa depan.',
            'kehamilan_ke.required'  => 'Kehamilan ke berapa wajib diisi.',
            'foto.max'               => 'Foto maksimal 2MB.',
            'foto.mimes'             => 'Foto harus berformat jpg, jpeg, png, atau webp.',
        ];
    }
}
