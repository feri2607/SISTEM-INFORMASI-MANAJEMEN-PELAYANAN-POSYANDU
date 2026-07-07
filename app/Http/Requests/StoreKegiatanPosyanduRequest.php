<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreKegiatanPosyanduRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'posyandu' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_pelayanan' => 'nullable|array',
            'target_peserta' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'status' => 'nullable|in:Draft,Terjadwal,Berlangsung,Selesai,Dibatalkan',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kuota' => 'nullable|integer',
        ];
    }
}
