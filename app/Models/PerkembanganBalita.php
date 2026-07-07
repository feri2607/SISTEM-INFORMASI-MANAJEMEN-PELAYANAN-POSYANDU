<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerkembanganBalita extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'balita_id',
        'tanggal',
        'motorik_kasar',
        'motorik_halus',
        'bahasa',
        'sosial',
        'catatan',
        'pegawai_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }
}
