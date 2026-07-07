<?php
// app/Models/KegiatanPosyandu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanPosyandu extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_posyandu';

    protected $fillable = [
        'nama_kegiatan',
        'posyandu',
        'deskripsi',
        'jenis_pelayanan',
        'target_peserta',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'status',
        'penanggung_jawab',
        'google_maps_embed',
        'kuota',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'jenis_pelayanan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(KehadiranKegiatan::class, 'kegiatan_id');
    }

    public function pelayanan()
    {
        return $this->hasMany(HasilPelayanan::class, 'kegiatan_id');
    }
}