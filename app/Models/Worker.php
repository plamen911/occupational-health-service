<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Updater;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory, SoftDeletes, Updater;

    protected $fillable = [
        'firm_id',
        'first_name',
        'second_name',
        'last_name',
        'gender',
        'id_number',
        'birth_date',
        'address',
        'email',
        'phone1',
        'phone2',
        'firm_structure_id',
        'family_doctor_id',
        'job_start_at',
        'career_start_at',
        'retired_at',
        'notes',
    ];

    protected $casts = [
        'firm_id' => 'integer',
        'birth_date' => 'datetime',
        'firm_structure_id' => 'integer',
        'family_doctor_id' => 'integer',
        'job_start_at' => 'datetime',
        'career_start_at' => 'datetime',
        'retired_at' => 'datetime',
    ];

    protected $dates = [
        'birth_date',
        'job_start_at',
        'career_start_at',
        'retired_at',
    ];

    protected $appends = [
        'full_name',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function firmStructure(): BelongsTo
    {
        return $this->belongsTo(FirmStructure::class);
    }

    public function familyDoctor(): BelongsTo
    {
        return $this->belongsTo(FamilyDoctor::class);
    }

    public function prophylacticCheckups(): HasMany
    {
        return $this->hasMany(ProphylacticCheckup::class);
    }

    public function patientCharts(): HasMany
    {
        return $this->hasMany(PatientChart::class);
    }

    public function setBirthDateAttribute(?string $input): void
    {
        $birthDate = null;
        if (! empty($input)) {
            try {
                $birthDate = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['birth_date'] = $birthDate;
    }

    public function setJobStartAtAttribute(?string $input): void
    {
        $jobStatAt = null;
        if (! empty($input)) {
            try {
                $jobStatAt = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['job_start_at'] = $jobStatAt;
    }

    public function setCareerStartAtAttribute(?string $input): void
    {
        $careerStartAt = null;
        if (! empty($input)) {
            try {
                $careerStartAt = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['career_start_at'] = $careerStartAt;
    }

    public function setRetiredAtAttribute(?string $input): void
    {
        $retiredAt = null;
        if (! empty($input)) {
            try {
                $retiredAt = Carbon::createFromFormat('d.m.Y', $input)->format('Y-m-d');
            } catch (Exception $ex) {
                //
            }
        }

        $this->attributes['retired_at'] = $retiredAt;
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->second_name.' '.$this->last_name);
    }
}
