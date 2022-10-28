<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class OhsConclusion extends Model
{
    use HasFactory, SoftDeletes;

    const CONDITIONS_ID = 2;

    protected $fillable = [
        'name',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function prophylacticCheckups(): HasMany
    {
        return $this->hasMany(ProphylacticCheckup::class);
    }

    public static function dropdown(): Collection
    {
        return self::orderBy('position')->pluck('name', 'id');
    }
}
