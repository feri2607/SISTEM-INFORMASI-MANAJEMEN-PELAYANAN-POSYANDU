<?php
// app/Http/Requests/WusRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $wus = $this->route('wus');

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique('wus')->ignore($wus)],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'status_pernikahan' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'golongan_darah' => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'riwayat_penyakit' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            
            // PUS (Pasangan Usia Subur) Fields
            'nama_pasangan' => ['nullable', 'required_if:status_pernikahan,Kawin', 'string', 'max:255'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK hanya boleh berupa angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'nama_pasangan.required_if' => 'Nama pasangan wajib diisi jika status pernikahan kawin.',
            'jumlah_anak.integer' => 'Jumlah anak harus berupa angka.',
        ];
    }
}