<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'title',
        'organization',
        'issued_at',
        'image',
    ];

    protected $casts = [
        'issued_at' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
