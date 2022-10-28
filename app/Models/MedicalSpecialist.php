<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class MedicalSpecialist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function prophylacticCheckups(): BelongsToMany
    {
        return $this->belongsToMany(ProphylacticCheckup::class)
            ->withPivot(['medical_opinion'])
            ->withTimestamps();
    }

    public static function dropdown(): Collection
    {
        return self::orderBy('name')
            ->pluck('name', 'id');
    }
}
