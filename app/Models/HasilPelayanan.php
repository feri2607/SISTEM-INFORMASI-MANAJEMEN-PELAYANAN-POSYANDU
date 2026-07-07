<?php
// app/Models/HasilPelayanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilPelayanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hasil_pelayanan';

    protected $fillable = [
        'kegiatan_id',
        'balita_id',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'suhu_tubuh',
        'status_gizi',
        'imunisasi',
        'vitamin',
        'catatan',
        'rekomendasi',
        'user_id',
    ];

    protected $casts = [
        'imunisasi' => 'array',
        'vitamin' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function kegiatan()
    {
        return $this->belongsTo(KegiatanPosyandu::class);
    }

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getStatusGiziLabelAttribute()
    {
        $labels = [
            'normal' => 'Gizi Baik',
            'kurang' => 'Gizi Kurang',
            'buruk' => 'Gizi Buruk',
            'lebih' => 'Gizi Lebih',
        ];
        return $labels[$this->status_gizi] ?? $this->status_gizi;
    }

    public function getStatusGiziColorAttribute()
    {
        $colors = [
            'normal' => 'green',
            'kurang' => 'orange',
            'buruk' => 'red',
            'lebih' => 'yellow',
        ];
        return $colors[$this->status_gizi] ?? 'gray';
    }

    public function getStatusGiziBadgeAttribute()
    {
        $badges = [
            'normal' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'kurang' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
            'buruk' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            'lebih' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        ];
        return $badges[$this->status_gizi] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400';
    }

    public function getImunisasiListAttribute()
    {
        if (!$this->imunisasi)
            return [];
        return $this->imunisasi;
    }

    public function getVitaminListAttribute()
    {
        if (!$this->vitamin)
            return [];
        return $this->vitamin;
    }

    public function getTanggalFormattedAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }
}