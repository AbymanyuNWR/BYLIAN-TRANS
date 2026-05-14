<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'pickup_location',
        'destination',
        'trip_type',
        'departure_date',
        'return_date',
        'passenger_count',
        'vehicle_preference',
        'duration',
        'message',
        'estimated_budget',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'estimated_budget' => 'decimal:2',
    ];
}
