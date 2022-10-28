<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Updater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{
    use HasFactory, SoftDeletes, Updater;

    protected $fillable = [
        'name',
        'manager',
        'address',
        'email',
        'phone1',
        'phone2',
        'notes',
    ];

    protected $casts = [
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function firmSubDivisions(): HasMany
    {
        return $this->hasMany(FirmSubDivision::class);
    }

    public function firmWorkPlaces(): HasMany
    {
        return $this->hasMany(FirmWorkPlace::class);
    }

    public function firmPositions(): HasMany
    {
        return $this->hasMany(FirmPosition::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class)->whereNull('retired_at');
    }

    public function patientCharts(): HasMany
    {
        return $this->hasMany(PatientChart::class);
    }
}
