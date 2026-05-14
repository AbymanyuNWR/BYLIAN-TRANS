<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Route extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'origin_city',
        'destination_city',
        'slug',
        'distance_km',
        'estimated_duration',
        'base_price',
        'description',
        'pickup_points',
        'dropoff_points',
        'status',
    ];

    protected $casts = [
        'pickup_points' => 'array',
        'dropoff_points' => 'array',
        'base_price' => 'decimal:2',
        'distance_km' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function ($model) {
                return $model->origin_city . ' to ' . $model->destination_city;
            })
            ->saveSlugsTo('slug');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
