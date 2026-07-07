<?php
// app/Models/JadwalKontrol.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrol extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kontrol';

    protected $fillable = [
        'wus_id',
        'user_id',
        'tanggal',
        'jam',
        'lokasi',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime',
    ];

    public function wus()
    {
        return $this->belongsTo(Wus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'terjadwal' => 'Terjadwal',
            'hadir' => 'Hadir',
            'tidak_hadir' => 'Tidak Hadir',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'terjadwal' => 'blue',
            'hadir' => 'green',
            'tidak_hadir' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'terjadwal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'tidak_hadir' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    }
}