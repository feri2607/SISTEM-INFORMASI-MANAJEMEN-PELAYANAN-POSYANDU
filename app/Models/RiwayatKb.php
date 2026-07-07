<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKb extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kb';

    protected $fillable = [
        'pus_id',
        'user_id',
        'tanggal',
        'jenis_kb',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pus()
    {
        return $this->belongsTo(Pus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
