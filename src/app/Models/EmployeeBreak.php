<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeBreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'week_day',
        'start_time',
        'end_time',
        'title',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
