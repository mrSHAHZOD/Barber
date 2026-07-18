<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignment uchun ruxsat etilgan ustunlar.
     */
    protected $fillable = [
        'business_id',
        'branch_id',
        'customer_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'note',
        'total_price',
    ];

    /**
     * Ustunlar uchun tur (cast) belgilash.
     */
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'total_price' => 'decimal:2',
        ];
    }
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
