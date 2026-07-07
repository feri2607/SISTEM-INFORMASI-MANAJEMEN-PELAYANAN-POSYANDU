<?php
// app/Models/KehadiranKegiatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'user_id',
        'peserta_id',
        'peserta_type',
        'kategori',
        'jam_datang',
        'status_kehadiran',
        'konfirmasi_at',
        'hadir_at',
        'status',
        'catatan',
    ];

    protected $casts = [
        'konfirmasi_at' => 'datetime',
        'hadir_at' => 'datetime',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(KegiatanPosyandu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peserta()
    {
        return $this->morphTo();
    }
}