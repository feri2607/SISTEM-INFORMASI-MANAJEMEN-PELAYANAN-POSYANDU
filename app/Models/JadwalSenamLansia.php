<?php
// app/Models/JadwalSenamLansia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSenamLansia extends Model
{
    use HasFactory;

    protected $table = 'jadwal_senam_lansia';

    protected $fillable = [
        'tanggal',
        'jam',
        'lokasi',
        'instruktur',
        'kuota',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kehadiran()
    {
        return $this->hasMany(KehadiranSenamLansia::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif'      => 'Aktif',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'aktif'      => 'green',
            'selesai'    => 'blue',
            'dibatalkan' => 'red',
            default      => 'gray',
        };
    }
}
