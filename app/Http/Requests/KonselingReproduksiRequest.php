<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonselingReproduksiRequest extends FormRequest
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
            'topik' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'wus_id.required' => 'WUS wajib dipilih.',
            'wus_id.exists' => 'WUS tidak valid.',
            'tanggal.required' => 'Tanggal konseling wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'topik.required' => 'Topik konseling wajib diisi.',
        ];
    }
}
