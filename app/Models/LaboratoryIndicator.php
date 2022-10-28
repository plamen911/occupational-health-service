<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class LaboratoryIndicator extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'min_value',
        'max_value',
        'dimension',
        'position',
    ];

    protected $casts = [
        'min_value' => 'float',
        'max_value' => 'float',
        'position' => 'integer',
    ];

    public function laboratoryResearches(): HasMany
    {
        return $this->hasMany(LaboratoryResearch::class);
    }

    public static function dropdown(): Collection
    {
        return self::orderBy('type')
            ->orderBy('name')
            ->orderBy('position')
            ->get()->mapWithKeys(function (LaboratoryIndicator $laboratoryIndicator) {
                return [
                    $laboratoryIndicator->id => $laboratoryIndicator->type.(! empty($laboratoryIndicator->name) ? ' ('.$laboratoryIndicator->name.')' : ''),
                ];
            });
    }
}
