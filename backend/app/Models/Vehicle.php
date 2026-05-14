<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_category_id',
        'name',
        'brand',
        'model',
        'plate_number',
        'year',
        'capacity',
        'fuel_type',
        'transmission',
        'color',
        'main_image',
        'gallery',
        'features',
        'daily_price',
        'hourly_price',
        'airport_price',
        'status',
        'last_service_date',
        'next_service_date',
        'insurance_expired_at',
        'tax_expired_at',
        'description',
    ];

    protected $casts = [
        'gallery' => 'array',
        'features' => 'array',
        'last_service_date' => 'date',
        'next_service_date' => 'date',
        'insurance_expired_at' => 'date',
        'tax_expired_at' => 'date',
        'daily_price' => 'decimal:2',
        'hourly_price' => 'decimal:2',
        'airport_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
