<?php
// app/Models/News.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'gallery',
        'category_id',
        'user_id',
        'status',
        'is_featured',
        'is_breaking',
        'views',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists('news/' . $this->thumbnail)) {
            return Storage::url('news/' . $this->thumbnail);
        }
        return asset('images/news-default.jpg');
    }

    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) return [];
        
        return array_map(function ($image) {
            if (Storage::disk('public')->exists('news/gallery/' . $image)) {
                return Storage::url('news/gallery/' . $image);
            }
            return asset('images/placeholder.jpg');
        }, $this->gallery);
    }

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

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return $minutes . ' menit';
    }

    public function getExcerptAttribute()
    {
        if ($this->attributes['excerpt']) {
            return $this->attributes['excerpt'];
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getIsNewAttribute()
    {
        if (!$this->published_at) return false;
        return $this->published_at->diffInDays(now()) <= 7;
    }

    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : '-';
    }

    public function getPublishedFullAttribute()
    {
        return $this->published_at ? $this->published_at->isoFormat('dddd, D MMMM YYYY') : '-';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRelatedNews($limit = 4)
    {
        return News::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPopularNews($limit = 5)
    {
        return News::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    // Boot
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
            if (empty($news->published_at) && $news->status === 'published') {
                $news->published_at = now();
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('status') && $news->status === 'published' && empty($news->published_at)) {
                $news->published_at = now();
            }
        });
    }
}