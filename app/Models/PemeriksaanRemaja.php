<?php
// app/Models/PemeriksaanRemaja.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanRemaja extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_remaja';

    protected $fillable = [
        'remaja_id',
        'user_id',
        'tanggal',
        'berat_badan',
        'tinggi_badan',
        'bmi',
        'tekanan_darah',
        'status_hb',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function remaja()
    {
        return $this->belongsTo(Remaja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusGiziAttribute()
    {
        if (!$this->bmi) return null;
        if ($this->bmi < 17) return 'Kurus';
        if ($this->bmi < 18.5) return 'Berisiko Kurus';
        if ($this->bmi < 25) return 'Normal';
        if ($this->bmi < 27) return 'Berisiko Gemuk';
        return 'Gemuk';
    }

    public function getStatusGiziColorAttribute()
    {
        $status = $this->status_gizi;
        if ($status === 'Normal') return 'green';
        if ($status === 'Kurus' || $status === 'Berisiko Kurus') return 'yellow';
        if ($status === 'Gemuk' || $status === 'Berisiko Gemuk') return 'orange';
        return 'gray';
    }
}