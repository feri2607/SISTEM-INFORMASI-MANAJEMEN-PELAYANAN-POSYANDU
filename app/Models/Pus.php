<?php
// app/Models/Pus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pus extends Model
{
    use HasFactory;

    protected $table = 'pus';

    protected $fillable = [
        'warga_id',
        'nama_pasangan',
        'jumlah_anak',
        'status_kb',
        'jenis_kontrasepsi',
        'tanggal_mulai_kb',
        'jadwal_kontrol',
    ];

    protected $casts = [
        'tanggal_mulai_kb' => 'date',
        'jadwal_kontrol' => 'date',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function wus()
    {
        return $this->belongsTo(Wus::class, 'warga_id', 'warga_id');
    }

    public function getStatusKbLabelAttribute()
    {
        $status = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'berhenti' => 'Berhenti',
        ];
        return $status[$this->status_kb] ?? $this->status_kb;
    }
}