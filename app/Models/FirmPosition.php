<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirmPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'name',
        'description',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }
}
