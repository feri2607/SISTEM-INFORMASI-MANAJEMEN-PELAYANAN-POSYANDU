<?php
// app/Models/PemeriksaanLansia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLansia extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_lansia';

    protected $fillable = [
        'lansia_id',
        'user_id',
        'tanggal',
        'tekanan_darah',
        'gula_darah',
        'kolesterol',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'lingkar_perut',
        'asam_urat',
        'keluhan',
        'tindakan',
        'catatan',
    ];

    protected $casts = [
        'tanggal'      => 'date',
        'gula_darah'   => 'float',
        'kolesterol'   => 'float',
        'berat_badan'  => 'float',
        'tinggi_badan' => 'float',
        'imt'          => 'float',
        'lingkar_perut'=> 'float',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusImtAttribute(): string
    {
        if (!$this->imt) return '-';
        if ($this->imt < 18.5) return 'Kurus';
        if ($this->imt < 25.0) return 'Normal';
        if ($this->imt < 30.0) return 'Gemuk';
        return 'Obesitas';
    }
}
