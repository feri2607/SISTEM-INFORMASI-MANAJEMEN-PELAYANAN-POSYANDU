<?php
// app/Models/KonselingReproduksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonselingReproduksi extends Model
{
    use HasFactory;

    protected $table = 'konseling_reproduksi';

    protected $fillable = [
        'wus_id',
        'user_id',
        'tanggal',
        'topik',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function wus()
    {
        return $this->belongsTo(Wus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
