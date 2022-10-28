<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class PatientChartType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function patientCharts(): BelongsToMany
    {
        return $this->belongsToMany(PatientChart::class, 'patient_chart_type');
    }

    public static function dropdown(): Collection
    {
        return self::orderBy('position')->pluck('name', 'id');
    }
}
