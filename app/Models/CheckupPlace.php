<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckupPlace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function prophylacticCheckups(): BelongsToMany
    {
        return $this->belongsToMany(ProphylacticCheckup::class, 'prophylactic_checkup_place')->withTimestamps();
    }
}
