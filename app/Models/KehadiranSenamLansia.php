<?php
// app/Models/KehadiranSenamLansia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranSenamLansia extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_senam_lansia';

    protected $fillable = [
        'jadwal_senam_lansia_id',
        'lansia_id',
        'hadir',
    ];

    protected $casts = [
        'hadir' => 'boolean',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalSenamLansia::class, 'jadwal_senam_lansia_id');
    }

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}
