<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MkbGroup extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'name'];

    protected $casts = [
        'class_id' => 'integer',
    ];

    public function mkbClass(): BelongsTo
    {
        return $this->belongsTo(MkbClass::class);
    }

    public function mkbCodes(): HasMany
    {
        return $this->hasMany(MkbCode::class);
    }
}
