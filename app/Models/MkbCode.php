<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MkbCode extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'code', 'name', 'edition'];

    protected $casts = [
        'group_id' => 'integer',
    ];

    public function mkbGroup(): BelongsTo
    {
        return $this->belongsTo(MkbGroup::class);
    }

    public function patientCharts(): HasMany
    {
        return $this->hasMany(PatientChart::class);
    }
}
