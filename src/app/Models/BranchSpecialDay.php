<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchSpecialDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'date',
        'start_time',
        'end_time',
        'is_closed',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
        'is_closed' => 'boolean',
    ];


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
