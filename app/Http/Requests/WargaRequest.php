<?php
// app/Http/Requests/WargaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $warga = $this->route('warga') ?? auth()->user()->warga ?? null;

        return [
            // Identitas
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique('warga')->ignore($warga)],
            'nomor_kk' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'golongan_darah' => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'agama' => ['nullable', 'string', 'max:50'],
            'status_pernikahan' => ['nullable', 'string', 'max:50'],
            'pendidikan' => ['nullable', 'string', 'max:100'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'telepon' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'email' => ['nullable', 'email', 'max:255'],

            // Alamat
            'alamat' => ['required', 'string'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],
            'dusun' => ['nullable', 'string', 'max:100'],
            'desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],

            // Administrasi
            'bpjs_number' => ['nullable', 'string', 'max:50'],
            'kis_number' => ['nullable', 'string', 'max:50'],
            'jkn_number' => ['nullable', 'string', 'max:50'],
            'status_kependudukan' => ['required', Rule::in(['tetap', 'pendatang'])],
            'status_keaktifan' => ['required', Rule::in(['aktif', 'tidak_aktif'])],

            // Dokumen
            'ktp_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'kk_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK hanya boleh berupa angka.',
            'nik.unique' => 'NIK sudah terdaftar.',

            'nomor_kk.required' => 'Nomor KK wajib diisi.',
            'nomor_kk.size' => 'Nomor KK harus 16 digit.',
            'nomor_kk.regex' => 'Nomor KK hanya boleh berupa angka.',

            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',

            'golongan_darah.in' => 'Golongan darah tidak valid.',

            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.regex' => 'Format nomor telepon tidak valid.',

            'email.email' => 'Format email tidak valid.',

            'alamat.required' => 'Alamat wajib diisi.',

            'status_kependudukan.required' => 'Status kependudukan wajib dipilih.',
            'status_kependudukan.in' => 'Status kependudukan tidak valid.',

            'status_keaktifan.required' => 'Status keaktifan wajib dipilih.',
            'status_keaktifan.in' => 'Status keaktifan tidak valid.',

            'ktp_path.mimes' => 'Format file KTP harus JPG, JPEG, PNG, atau PDF.',
            'ktp_path.max' => 'Ukuran file KTP maksimal 2 MB.',

            'kk_path.mimes' => 'Format file KK harus JPG, JPEG, PNG, atau PDF.',
            'kk_path.max' => 'Ukuran file KK maksimal 2 MB.',
        ];
    }
}