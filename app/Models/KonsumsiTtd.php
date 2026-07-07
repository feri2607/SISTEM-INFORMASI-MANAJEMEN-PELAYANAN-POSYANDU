<?php
// app/Models/KonsumsiTtd.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsumsiTtd extends Model
{
    use HasFactory;

    protected $table = 'konsumsi_ttd';

    protected $fillable = [
        'kehamilan_id',
        'jumlah_target',
        'jumlah_diminum',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function kehamilan()
    {
        return $this->belongsTo(Kehamilan::class);
    }

    public function getPersentaseAttribute()
    {
        if (!$this->jumlah_target || $this->jumlah_target === 0) return 0;
        return min(100, round(($this->jumlah_diminum / $this->jumlah_target) * 100));
    }

    public function getSisaAttribute()
    {
        return max(0, $this->jumlah_target - $this->jumlah_diminum);
    }
}
