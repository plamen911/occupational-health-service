<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Updater;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProphylacticCheckup extends Model
{
    use HasFactory, SoftDeletes, Updater;

    protected $fillable = [
        'firm_id',
        'worker_id',
        'checkup_num',
        'checkup_date',
        'worker_height',
        'worker_weight',
        'rr_systolic',
        'rr_diastolic',
        'is_smoking',
        'is_drinking',
        'has_bad_nutrition',
        'in_on_diet',
        'has_home_stress',
        'has_work_stress',
        'has_social_stress',
        'has_long_screen_time',
        'sport_hours',
        'has_low_activity',
        'left_eye',
        'left_eye2',
        'right_eye',
        'right_eye2',
        'breath_vk',
        'breath_feo',
        'breath_tifno',
        'hearing_loss_id',
        'left_ear',
        'right_ear',
        'tone_audiometry',
        'electrocardiogram',
        'x_ray',
        'echo_ray',
        'family_medical_history',
        'medical_history',
        'ohs_conclusion_id',
        'ohs_conditions',
        'ohs_date',
    ];

    protected $casts = [
        'firm_id' => 'integer',
        'worker_id' => 'integer',
        'checkup_date' => 'datetime',
        'worker_height' => 'float',
        'worker_weight' => 'float',
        'rr_systolic' => 'integer',
        'rr_diastolic' => 'integer',
        'is_smoking' => 'integer',
        'is_drinking' => 'integer',
        'has_bad_nutrition' => 'integer',
        'in_on_diet' => 'integer',
        'has_home_stress' => 'integer',
        'has_work_stress' => 'integer',
        'has_social_stress' => 'integer',
        'has_long_screen_time' => 'integer',
        'sport_hours' => 'float',
        'has_low_activity' => 'integer',
        'left_eye' => 'float',
        'left_eye2' => 'float',
        'right_eye' => 'float',
        'right_eye2' => 'float',
        'breath_vk' => 'float',
        'breath_feo' => 'float',
        'breath_tifno' => 'float',
        'hearing_loss_id' => 'integer',
        'left_ear' => 'float',
        'right_ear' => 'float',
        'ohs_conclusion_id' => 'integer',
        'ohs_date' => 'datetime',
    ];

    protected $dates = [
        'checkup_date',
        'ohs_date',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function hearingLoss(): BelongsTo
    {
        return $this->belongsTo(HearingLoss::class);
    }

    public function ohsConclusion(): BelongsTo
    {
        return $this->belongsTo(OhsConclusion::class);
    }

    public function checkupPlaces(): BelongsToMany
    {
        return $this->belongsToMany(CheckupPlace::class, 'prophylactic_checkup_place')->withTimestamps();
    }

    public function familyAnamneses(): HasMany
    {
        return $this->hasMany(FamilyAnamnesis::class);
    }

    public function anamneses(): HasMany
    {
        return $this->hasMany(Anamnesis::class);
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function laboratoryResearches(): HasMany
    {
        return $this->hasMany(LaboratoryResearch::class);
    }

    public function medicalSpecialists(): BelongsToMany
    {
        return $this->belongsToMany(MedicalSpecialist::class)
            ->withPivot(['medical_opinion'])
            ->withTimestamps()
            ->orderByPivot('position');
    }

    public function setCheckupDateAttribute(?string $input): void
    {
        $checkupDate = null;
        if (! empty($input)) {
            try {
                $checkupDate = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['checkup_date'] = $checkupDate;
    }

    public function setOhsDateAttribute(?string $input): void
    {
        $ohsDate = null;
        if (! empty($input)) {
            try {
                $ohsDate = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['ohs_date'] = $ohsDate;
    }
}
