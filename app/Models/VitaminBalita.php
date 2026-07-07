<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VitaminBalita extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'balita_id',
        'jenis_vitamin',
        'dosis',
        'tanggal',
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
