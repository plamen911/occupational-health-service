<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalExperience extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'worker_id',
        'firm_name',
        'job_position',
        'years_length',
        'months_length',
        'position'
    ];

    protected $casts = [
        'worker_id' => 'integer',
        'years_length' => 'integer',
        'months_length' => 'integer',
        'position' => 'integer',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
