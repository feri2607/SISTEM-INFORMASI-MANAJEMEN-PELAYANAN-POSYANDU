<?php
// app/Http/Requests/PelayananRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PelayananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kegiatan_id' => ['required', 'exists:kegiatan_posyandu,id'],
            'balita_id' => ['required', 'exists:balita,id'],
            'berat_badan' => ['required', 'numeric', 'min:0.5', 'max:200'],
            'tinggi_badan' => ['required', 'numeric', 'min:30', 'max:200'],
            'lingkar_kepala' => ['required', 'numeric', 'min:20', 'max:60'],
            'lingkar_lengan' => ['nullable', 'numeric', 'min:5', 'max:40'],
            'suhu_tubuh' => ['nullable', 'numeric', 'min:35', 'max:42'],
            'imunisasi' => ['nullable', 'array'],
            'imunisasi.*' => ['string', Rule::in(['BCG', 'Polio', 'DPT', 'Campak', 'Hepatitis', 'Lainnya'])],
            'vitamin' => ['nullable', 'array'],
            'vitamin.*' => ['string', Rule::in(['Vitamin A', 'Obat Cacing', 'PMT'])],
            'catatan' => ['nullable', 'string'],
            'rekomendasi' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kegiatan_id.required' => 'Kegiatan wajib dipilih.',
            'kegiatan_id.exists' => 'Kegiatan tidak valid.',

            'balita_id.required' => 'Balita wajib dipilih.',
            'balita_id.exists' => 'Balita tidak valid.',

            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'berat_badan.min' => 'Berat badan minimal 0.5 kg.',
            'berat_badan.max' => 'Berat badan maksimal 200 kg.',

            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'tinggi_badan.min' => 'Tinggi badan minimal 30 cm.',
            'tinggi_badan.max' => 'Tinggi badan maksimal 200 cm.',

            'lingkar_kepala.required' => 'Lingkar kepala wajib diisi.',
            'lingkar_kepala.numeric' => 'Lingkar kepala harus berupa angka.',
            'lingkar_kepala.min' => 'Lingkar kepala minimal 20 cm.',
            'lingkar_kepala.max' => 'Lingkar kepala maksimal 60 cm.',

            'lingkar_lengan.numeric' => 'Lingkar lengan harus berupa angka.',
            'lingkar_lengan.min' => 'Lingkar lengan minimal 5 cm.',
            'lingkar_lengan.max' => 'Lingkar lengan maksimal 40 cm.',

            'suhu_tubuh.numeric' => 'Suhu tubuh harus berupa angka.',
            'suhu_tubuh.min' => 'Suhu tubuh minimal 35°C.',
            'suhu_tubuh.max' => 'Suhu tubuh maksimal 42°C.',
        ];
    }
}