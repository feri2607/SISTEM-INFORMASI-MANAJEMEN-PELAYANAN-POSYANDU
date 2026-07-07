<?php
// app/Models/Anc.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anc extends Model
{
    use HasFactory;

    protected $table = 'anc';

    protected $fillable = [
        'kehamilan_id',
        'user_id',
        'tanggal',
        'minggu_ke',
        'tekanan_darah',
        'berat_badan',
        'lila',
        'tinggi_fundus',
        'detak_jantung',
        'posisi_janin',
        'keluhan',
        'diagnosis',
        'pemberian_ttd',
        'rujukan',
        'catatan',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'pemberian_ttd' => 'boolean',
        'rujukan'       => 'boolean',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusRisikoAttribute()
    {
        $sistol = null;
        if ($this->tekanan_darah && str_contains($this->tekanan_darah, '/')) {
            $sistol = (int) explode('/', $this->tekanan_darah)[0];
        }

        if ($sistol && $sistol >= 140) return 'Risiko Tinggi';
        if ($this->rujukan)            return 'Dirujuk';
        return 'Normal';
    }

    public function getStatusRisikoBadgeAttribute()
    {
        return match($this->status_risiko) {
            'Risiko Tinggi' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            'Dirujuk'       => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
            default         => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        };
    }
}
