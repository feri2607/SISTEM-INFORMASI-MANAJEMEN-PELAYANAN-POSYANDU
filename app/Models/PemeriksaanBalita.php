<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemeriksaanBalita extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'balita_id',
        'tanggal_pemeriksaan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'status_gizi',
        'status_perkembangan',
        'keluhan_orang_tua',
        'catatan_pegawai',
        'pegawai_id'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function getStatusGiziLabelAttribute()
    {
        $status = $this->status_gizi;
        $labels = [
            'normal' => 'Normal',
            'kurang' => 'Kurang',
            'buruk' => 'Buruk',
            'lebih' => 'Lebih',
        ];
        return $labels[$status] ?? '-';
    }

    public function getStatusGiziColorAttribute()
    {
        $status = $this->status_gizi;
        $colors = [
            'normal' => 'green',
            'kurang' => 'yellow',
            'buruk' => 'red',
            'lebih' => 'orange',
        ];
        return $colors[$status] ?? 'gray';
    }
}
