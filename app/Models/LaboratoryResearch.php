<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaboratoryResearch extends Model
{
    use HasFactory;

    protected $table = 'laboratory_researches';

    protected $fillable = [
        'prophylactic_checkup_id',
        'laboratory_indicator_id',
        'type',
        'value',
    ];

    protected $casts = [
        'prophylactic_checkup_id' => 'integer',
        'laboratory_indicator_id' => 'integer',
    ];

    public function prophylacticCheckup(): BelongsTo
    {
        return $this->belongsTo(ProphylacticCheckup::class);
    }

    public function laboratoryIndicator(): BelongsTo
    {
        return $this->belongsTo(LaboratoryIndicator::class);
    }
}
