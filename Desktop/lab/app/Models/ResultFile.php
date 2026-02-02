<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultFile extends Model
{
    protected $fillable = [
        'test_result_id',
        'file_path',
        'file_name',
        'original_name',
        'mime',
        'file_type',
        'file_size',
    ];

    /**
     * Get the test result that owns the result file.
     */
    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }
}
