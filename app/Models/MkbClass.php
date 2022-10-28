<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\TextUI\XmlConfiguration\Group;

class MkbClass extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function mkbGroups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
