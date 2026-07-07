<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkriningReproduksi extends Model
{
    use HasFactory;

    protected $table = 'skrining_reproduksi';

    protected $fillable = [
        'warga_id',
        'user_id',
        'tanggal',
        'status_risiko',
        'rekomendasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
