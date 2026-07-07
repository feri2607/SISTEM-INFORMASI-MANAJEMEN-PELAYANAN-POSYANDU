<?php
// app/Models/Article.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'category_id',
        'user_id',
        'status',
        'is_featured',
        'views',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Accessors
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists('articles/' . $this->thumbnail)) {
            return Storage::url('articles/' . $this->thumbnail);
        }
        return asset('images/article-default.jpg');
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

    public function getMetaTitleAttribute()
    {
        return $this->attributes['meta_title'] ?? $this->title;
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->attributes['meta_description'] ?? $this->excerpt;
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRelatedArticles($limit = 3)
    {
        return Article::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPopularArticles($limit = 5)
    {
        return Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    // Boot
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if (empty($article->published_at) && $article->status === 'published') {
                $article->published_at = now();
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('status') && $article->status === 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }
}