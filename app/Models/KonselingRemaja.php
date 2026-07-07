<?php
// app/Models/KonselingRemaja.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonselingRemaja extends Model
{
    use HasFactory;

    protected $table = 'konseling_remaja';

    protected $fillable = [
        'remaja_id',
        'user_id',
        'tanggal',
        'topik',
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

    public function getTopikLabelAttribute()
    {
        $labels = [
            'Bullying'          => '🛡️ Bullying',
            'Narkoba'           => '🚫 Narkoba',
            'Kesehatan Mental'  => '🧠 Kesehatan Mental',
            'Merokok'           => '🚬 Merokok',
            'Gizi'              => '🥗 Gizi',
            'Lainnya'           => '📝 Lainnya',
        ];

        return $labels[$this->topik] ?? $this->topik;
    }
}
