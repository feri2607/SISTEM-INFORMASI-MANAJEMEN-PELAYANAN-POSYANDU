<?php
// app/Http/Requests/PemeriksaanLansiaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PemeriksaanLansiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'pegawai']);
    }

    public function rules(): array
    {
        return [
            'lansia_id'    => ['required', 'exists:lansia,id'],
            'tanggal'      => ['required', 'date', 'before_or_equal:today'],
            'keluhan'      => ['nullable', 'string', 'max:255'],
            'tekanan_darah'=> ['nullable', 'string', 'max:20', 'regex:/^\d{2,3}\s*\/\s*\d{2,3}$/'],
            'gula_darah'   => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'kolesterol'   => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'asam_urat'    => ['nullable', 'numeric', 'min:0', 'max:999'],
            'berat_badan'  => ['nullable', 'numeric', 'min:1', 'max:300'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:50', 'max:300'],
            'lingkar_perut'=> ['nullable', 'numeric', 'min:0', 'max:999'],
            'catatan'      => ['nullable', 'string', 'max:2000'],
            'tindakan'     => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'lansia_id.required'     => 'Data lansia wajib dipilih.',
            'tanggal.required'       => 'Tanggal pemeriksaan wajib diisi.',
            'tanggal.before_or_equal'=> 'Tanggal pemeriksaan tidak boleh melebihi hari ini.',
            'tekanan_darah.regex'    => 'Format tekanan darah: sistolik/diastolik (misal: 120/80).',
            'berat_badan.min'        => 'Berat badan minimal 1 kg.',
            'tinggi_badan.min'       => 'Tinggi badan minimal 50 cm.',
        ];
    }
}
