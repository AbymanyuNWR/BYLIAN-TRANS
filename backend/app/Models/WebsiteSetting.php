<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_tagline',
        'site_description',
        'logo',
        'favicon',
        'phone',
        'whatsapp_number',
        'email',
        'address',
        'google_maps_embed',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'business_hours',
        'footer_text',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
