<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientChartReason extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public static function dropdown(): \Illuminate\Support\Collection
    {
        return self::orderBy('position')->get()
            ->mapWithKeys(fn (PatientChartReason $patientChartReason) => [
                $patientChartReason->id => $patientChartReason->code.' - '.$patientChartReason->name,
            ]);
    }
}
