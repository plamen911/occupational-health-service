<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyAnamnesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'prophylactic_checkup_id',
        'mkb_code_id',
        'diagnosis',
    ];

    protected $casts = [
        'prophylactic_checkup_id' => 'integer',
        'mkb_code_id' => 'integer',
    ];

    public function prophylacticCheckup(): BelongsTo
    {
        return $this->belongsTo(ProphylacticCheckup::class);
    }

    public function mkbCode(): BelongsTo
    {
        return $this->belongsTo(MkbCode::class);
    }
}
