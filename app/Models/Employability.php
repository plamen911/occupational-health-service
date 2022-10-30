<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employability extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'worker_id',
        'published_at',
        'mkb_code_id',
        'diagnosis',
        'authorities',
        'start_date',
        'end_date',
        'employability_place',
        'position',
    ];

    protected $casts = [
        'worker_id' => 'integer',
        'published_at' => 'datetime',
        'mkb_code_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'position' => 'integer',
    ];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function mkbCode(): BelongsTo
    {
        return $this->belongsTo(MkbCode::class);
    }
}
