<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_id',
        'service_id',
        'route_id',
        'schedule_id',
        'vehicle_id',
        'driver_id',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'pickup_time',
        'passenger_count',
        'customer_name',
        'customer_phone',
        'customer_email',
        'notes',
        'total_price',
        'discount',
        'final_price',
        'promo_code_id',
        'payment_status',
        'booking_status',
        'source',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $datePart = now()->format('Ymd');
                $latestToday = static::whereDate('created_at', now()->toDateString())
                    ->latest('id')
                    ->first();
                
                $sequence = 1;
                if ($latestToday && preg_match('/-(\d+)$/', $latestToday->booking_code, $matches)) {
                    $sequence = intval($matches[1]) + 1;
                }
                
                $booking->booking_code = 'BYT-' . $datePart . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(TransportService::class, 'service_id');
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
