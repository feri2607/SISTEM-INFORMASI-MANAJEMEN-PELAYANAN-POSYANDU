<?php
// app/Http/Requests/BalitaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BalitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $balita = $this->route('balita');
        $user = Auth::user();
        
        $rules = [
            'nama' => ['required', 'string', 'min:3', 'max:100'],
            'nik' => ['nullable', 'string', 'max:16'],
            'nomor_kk' => ['nullable', 'string', 'max:16'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:50'],
            'nama_ayah' => ['nullable', 'string', 'max:100'],
            'nama_ibu' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'golongan_darah' => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'no_hp_orang_tua' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ];

        // Hanya Admin dan Pegawai yang bisa mengisi data kesehatan & mengatur milik siapa balita ini
        if (in_array($user->role, ['admin', 'pegawai'])) {
            $rules['warga_id'] = ['required', 'exists:warga,id'];
            $rules['berat_lahir'] = ['nullable', 'numeric', 'min:0.5', 'max:10'];
            $rules['panjang_lahir'] = ['nullable', 'numeric', 'min:30', 'max:70'];
            $rules['anak_ke'] = ['nullable', 'integer', 'min:1', 'max:20'];
            $rules['keterangan'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama balita wajib diisi.',
            'nama.min' => 'Nama balita minimal 3 karakter.',
            'nama.max' => 'Nama balita maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'golongan_darah.in' => 'Golongan darah tidak valid.',
            'berat_lahir.numeric' => 'Berat lahir harus berupa angka.',
            'berat_lahir.min' => 'Berat lahir minimal 0.5 kg.',
            'berat_lahir.max' => 'Berat lahir maksimal 10 kg.',
            'panjang_lahir.numeric' => 'Panjang lahir harus berupa angka.',
            'panjang_lahir.min' => 'Panjang lahir minimal 30 cm.',
            'panjang_lahir.max' => 'Panjang lahir maksimal 70 cm.',
            'anak_ke.integer' => 'Anak ke harus berupa angka.',
            'anak_ke.min' => 'Anak ke minimal 1.',
            'anak_ke.max' => 'Anak ke maksimal 20.',
        ];
    }
}