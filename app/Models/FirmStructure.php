<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirmStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'firm_sub_division_id',
        'firm_work_place_id',
        'firm_position_id',
    ];

    protected $casts = [
        'firm_id' => 'integer',
        'firm_sub_division_id' => 'integer',
        'firm_work_place_id' => 'integer',
        'firm_position_id' => 'integer',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function firmSubDivision(): BelongsTo
    {
        return $this->belongsTo(FirmSubDivision::class);
    }

    public function firmWorkPlace(): BelongsTo
    {
        return $this->belongsTo(FirmWorkPlace::class);
    }

    public function firmPosition(): BelongsTo
    {
        return $this->belongsTo(FirmPosition::class);
    }
}
