<?php
// app/Http/Requests/AnakRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnakRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'           => ['required', 'string', 'max:255'],
            'nik'            => ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'tanggal_lahir'  => ['required', 'date', 'before_or_equal:today'],
            'jenis_kelamin'  => ['required', Rule::in(['L', 'P'])],
            'status_anak'    => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama anak wajib diisi.',
            'nik.size'               => 'NIK anak harus 16 digit.',
            'nik.regex'              => 'NIK anak hanya boleh berupa angka.',
            'tanggal_lahir.required' => 'Tanggal lahir anak wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin anak wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
            'status_anak.required'   => 'Status anak wajib dipilih.',
            'status_anak.in'         => 'Status anak tidak valid.',
        ];
    }
}
