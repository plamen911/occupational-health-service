<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Updater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientChart extends Model
{
    use HasFactory, SoftDeletes, Updater;

    protected $fillable = [
        'firm_id',
        'worker_id',
        'reg_num',
        'start_date',
        'end_date',
        'days_off',
        'mkb_code_id',
        'patient_chart_reason_id',
        'notes',
    ];

    protected $casts = [
        'firm_id' => 'integer',
        'worker_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'days_off' => 'integer',
        'mkb_code_id' => 'integer',
        'patient_chart_reason_id' => 'integer',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function mkbCode(): BelongsTo
    {
        return $this->belongsTo(MkbCode::class);
    }

    public function patientChartReason(): BelongsTo
    {
        return $this->belongsTo(PatientChartReason::class);
    }

    public function patientChartTypes(): BelongsToMany
    {
        return $this->belongsToMany(PatientChartType::class, 'patient_chart_type');
    }
}
