<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeWorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'week_day',
        'start_time',
        'end_time',
        'is_day_off',
    ];

    protected $casts = [
        'is_day_off' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
