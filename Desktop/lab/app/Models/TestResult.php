<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'result_data',
        'status',
        'completed_at',
        'published_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Get the appointment that owns the test result.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the result files for the test result.
     */
    public function resultFiles(): HasMany
    {
        return $this->hasMany(ResultFile::class);
    }
}
