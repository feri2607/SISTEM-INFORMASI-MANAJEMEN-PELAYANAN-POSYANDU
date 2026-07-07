<?php
// app/Http/Requests/PemeriksaanRemajaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemeriksaanRemajaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'remaja_id' => ['required', 'exists:remaja,id'],
            'tanggal' => ['required', 'date'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:100', 'max:250'],
            'tekanan_darah' => ['nullable', 'string', 'max:20'],
            'status_hb' => ['nullable', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'remaja_id.required' => 'Remaja wajib dipilih.',
            'remaja_id.exists' => 'Remaja tidak valid.',
            'tanggal.required' => 'Tanggal pemeriksaan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'berat_badan.min' => 'Berat badan minimal 20 kg.',
            'berat_badan.max' => 'Berat badan maksimal 200 kg.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'tinggi_badan.min' => 'Tinggi badan minimal 100 cm.',
            'tinggi_badan.max' => 'Tinggi badan maksimal 250 cm.',
        ];
    }
}