<?php
// app/Models/PelayananReproduksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananReproduksi extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_reproduksi';

    protected $fillable = [
        'wus_id',
        'user_id',
        'tanggal',
        'jenis_pelayanan',
        'jenis_kontrasepsi',
        'hasil_pemeriksaan',
        'catatan',
        'jadwal_kontrol_berikutnya',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jadwal_kontrol_berikutnya' => 'date',
    ];

    public function wus()
    {
        return $this->belongsTo(Wus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJenisPelayananLabelAttribute()
    {
        $labels = [
            'konsultasi' => 'Konsultasi KB',
            'pemasangan_kb' => 'Pemasangan KB',
            'kontrol' => 'Kontrol KB',
            'skrining' => 'Skrining Kesehatan',
            'konseling' => 'Konseling',
        ];
        return $labels[$this->jenis_pelayanan] ?? $this->jenis_pelayanan;
    }
}