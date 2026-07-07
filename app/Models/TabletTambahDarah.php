<?php
// app/Models/TabletTambahDarah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabletTambahDarah extends Model
{
    use HasFactory;

    protected $table = 'tablet_tambah_darah';

    protected $fillable = [
        'remaja_id',
        'target',
        'dikonsumsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function remaja()
    {
        return $this->belongsTo(Remaja::class);
    }

    public function getPersentaseAttribute()
    {
        if (!$this->target || $this->target === 0) return 0;
        return min(100, round(($this->dikonsumsi / $this->target) * 100));
    }

    public function getSisaAttribute()
    {
        return max(0, $this->target - $this->dikonsumsi);
    }
}
