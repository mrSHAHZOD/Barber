<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'branch_id',
        'employee_position_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'experience_years',
        'about',
        'photo',
        'rating',
        'is_active',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(EmployeePosition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workingHours(): HasMany
    {
        return $this->hasMany(EmployeeWorkingHour::class);
    }

    public function breaks(): HasMany
    {
        return $this->hasMany(EmployeeBreak::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->withTimestamps();
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(EmployeePortfolio::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(EmployeeCertificate::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(EmployeeSocialLink::class);
    }

    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
