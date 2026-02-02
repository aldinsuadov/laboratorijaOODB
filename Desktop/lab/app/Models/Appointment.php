<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'test_type_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    /**
     * Get the patient that owns the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the test type that owns the appointment.
     */
    public function testType(): BelongsTo
    {
        return $this->belongsTo(TestType::class);
    }

    /**
     * Get the test result for the appointment.
     */
    public function testResult(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }
}
