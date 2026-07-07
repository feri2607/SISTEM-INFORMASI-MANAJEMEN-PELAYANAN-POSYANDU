<?php
// app/Http/Requests/KonselingRemajaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KonselingRemajaRequest extends FormRequest
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
            'topik' => ['required', Rule::in(['Bullying', 'Narkoba', 'Kesehatan Mental', 'Merokok', 'Gizi', 'Lainnya', 'bullying', 'narkoba', 'kesehatan_mental', 'merokok', 'gizi', 'lainnya'])],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'remaja_id.required' => 'Remaja wajib dipilih.',
            'remaja_id.exists' => 'Remaja tidak valid.',
            'tanggal.required' => 'Tanggal konseling wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'topik.required' => 'Topik konseling wajib dipilih.',
            'topik.in' => 'Topik konseling tidak valid.',
        ];
    }
}