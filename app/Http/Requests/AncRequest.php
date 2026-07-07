<?php
// app/Http/Requests/AncRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AncRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['pegawai', 'admin']);
    }

    public function rules(): array
    {
        return [
            'kehamilan_id'  => ['required', 'exists:kehamilan,id'],
            'tanggal'       => ['required', 'date', 'before_or_equal:today'],
            'tekanan_darah' => ['nullable', 'string', 'max:20'],
            'berat_badan'   => ['nullable', 'numeric', 'min:30', 'max:200'],
            'lila'          => ['nullable', 'numeric', 'min:10', 'max:50'],
            'tinggi_fundus' => ['nullable', 'numeric', 'min:0', 'max:45'],
            'detak_jantung' => ['nullable', 'integer', 'min:60', 'max:200'],
            'posisi_janin'  => ['nullable', 'string', 'max:100'],
            'keluhan'       => ['nullable', 'string', 'max:1000'],
            'diagnosis'     => ['nullable', 'string', 'max:1000'],
            'pemberian_ttd' => ['nullable', 'boolean'],
            'rujukan'       => ['nullable', 'boolean'],
            'catatan'       => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'kehamilan_id.required' => 'Data kehamilan wajib dipilih.',
            'tanggal.required'      => 'Tanggal pemeriksaan wajib diisi.',
            'berat_badan.min'       => 'Berat badan tidak valid.',
            'detak_jantung.min'     => 'Detak jantung tidak valid.',
        ];
    }
}
