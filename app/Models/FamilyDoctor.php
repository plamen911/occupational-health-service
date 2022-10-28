<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Updater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class FamilyDoctor extends Model
{
    use HasFactory, SoftDeletes, Updater;

    protected $fillable = [
        'name',
        'address',
        'phone1',
        'phone2',
    ];

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public static function dropdown(): Collection
    {
        return self::orderBy('name')->pluck('name', 'id');
    }
}
