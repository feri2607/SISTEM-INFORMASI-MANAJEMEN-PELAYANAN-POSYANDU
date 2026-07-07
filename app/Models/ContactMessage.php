<?php
// app/Models/ContactMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Accessors
    public function getStatusLabelAttribute()
    {
        return $this->is_read ? 'Sudah Dibaca' : 'Belum Dibaca';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_read ? 'green' : 'red';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_read 
            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
            : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit($this->message, 100);
    }
}