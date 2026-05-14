<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'default_message',
        'booking_message',
        'charter_message',
        'payment_message',
        'driver_message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
