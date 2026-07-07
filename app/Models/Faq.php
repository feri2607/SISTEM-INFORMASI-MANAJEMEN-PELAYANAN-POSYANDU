<?php
// app/Models/Faq.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_featured',
        'status',
        'views',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'published' => 'green',
            'archived' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'published' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'archived' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    }

    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->answer), 150);
    }

    public function getCategoryLabelAttribute()
    {
        $categories = $this->getCategoryList();
        return $categories[$this->category] ?? $this->category ?? 'Umum';
    }

    public static function getCategoryList()
    {
        return [
            'pendaftaran' => 'Pendaftaran',
            'jadwal' => 'Jadwal Posyandu',
            'balita' => 'Balita',
            'imunisasi' => 'Imunisasi',
            'pelayanan' => 'Pelayanan',
            'akun' => 'Akun',
            'warga' => 'Warga',
            'kader' => 'Kader',
            'umum' => 'Umum',
        ];
    }

    // Scope
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getPopularFaqs($limit = 5)
    {
        return Faq::published()
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }
}