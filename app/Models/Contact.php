<?php
// app/Models/Contact.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'whatsapp',
        'email',
        'website',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'google_maps_url',
        'office_hours',
    ];

    // Accessors
    public function getPhoneFormattedAttribute()
    {
        return $this->phone;
    }

    public function getWhatsappFormattedAttribute()
    {
        // Format WhatsApp number for link
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }
        return $number;
    }

    public function getSocialMediaAttribute()
    {
        $social = [];
        if ($this->facebook) $social['facebook'] = $this->facebook;
        if ($this->instagram) $social['instagram'] = $this->instagram;
        if ($this->youtube) $social['youtube'] = $this->youtube;
        if ($this->tiktok) $social['tiktok'] = $this->tiktok;
        if ($this->whatsapp) $social['whatsapp'] = $this->whatsapp;
        return $social;
    }

    public function getOfficeHoursArrayAttribute()
    {
        return explode("\n", $this->office_hours);
    }
}