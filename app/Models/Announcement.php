<?php
// app/Models/Announcement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'attachment',
        'category_id',
        'user_id',
        'priority',
        'status',
        'publish_at',
        'expire_at',
        'views',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'expire_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(AnnouncementCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment && Storage::disk('public')->exists('announcements/' . $this->attachment)) {
            return Storage::url('announcements/' . $this->attachment);
        }
        return null;
    }

    public function getAttachmentNameAttribute()
    {
        if ($this->attachment) {
            return basename($this->attachment);
        }
        return null;
    }

    public function getIsAttachmentImageAttribute()
    {
        if (!$this->attachment) return false;
        
        $extension = strtolower(pathinfo($this->attachment, PATHINFO_EXTENSION));
        return in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'gif']);
    }

    public function getPriorityLabelAttribute()
    {
        $labels = [
            'normal' => 'Normal',
            'important' => 'Penting',
            'very_important' => 'Sangat Penting',
        ];
        return $labels[$this->priority] ?? $this->priority;
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            'normal' => 'blue',
            'important' => 'orange',
            'very_important' => 'red',
        ];
        return $colors[$this->priority] ?? 'gray';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'normal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'important' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
            'very_important' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];
        return $badges[$this->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'published' => 'Published',
            'scheduled' => 'Scheduled',
            'archived' => 'Archived',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'published' => 'green',
            'scheduled' => 'yellow',
            'archived' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'published' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'scheduled' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'archived' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400';
    }

    public function getExcerptAttribute()
    {
        if ($this->attributes['excerpt']) {
            return $this->attributes['excerpt'];
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getIsActiveAttribute()
    {
        if ($this->status !== 'published') return false;
        if ($this->publish_at && $this->publish_at > now()) return false;
        if ($this->expire_at && $this->expire_at < now()) return false;
        return true;
    }

    public function getPublishDateAttribute()
    {
        return $this->publish_at ? $this->publish_at->format('d M Y') : '-';
    }

    public function getPublishFullAttribute()
    {
        return $this->publish_at ? $this->publish_at->isoFormat('dddd, D MMMM YYYY') : '-';
    }

    public function getExpireDateAttribute()
    {
        return $this->expire_at ? $this->expire_at->format('d M Y') : 'Tidak terbatas';
    }

    public function getIsExpiredAttribute()
    {
        return $this->expire_at && $this->expire_at < now();
    }

    public function getIsScheduledAttribute()
    {
        return $this->status === 'scheduled' || ($this->publish_at && $this->publish_at > now());
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRelatedAnnouncements($limit = 4)
    {
        return Announcement::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_at')
                      ->orWhere('publish_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expire_at')
                      ->orWhere('expire_at', '>=', now());
            })
            ->orderBy('publish_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLatestAnnouncements($limit = 5)
    {
        return Announcement::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_at')
                      ->orWhere('publish_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expire_at')
                      ->orWhere('expire_at', '>=', now());
            })
            ->orderBy('publish_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // Boot
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title);
            }
        });

        static::saving(function ($announcement) {
            // Auto set status based on dates
            if ($announcement->status === 'published' && $announcement->publish_at && $announcement->publish_at > now()) {
                $announcement->status = 'scheduled';
            }
        });
    }
}