<?php

declare(strict_types=1);

namespace App\Http\Livewire\Workers;

use App\Models\FamilyDoctor;
use App\Models\Worker;
use App\Services\BgEgnService;
use App\Services\FirmService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Form extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public array $item = [
        'first_name' => '',
        'second_name' => '',
        'last_name' => '',
        'gender' => '',
        'id_number' => '',
        'birth_date' => '',
        'address' => '',
        'phone1' => '',
        'phone2' => '',
        'job_start_at' => '',
        'career_start_at' => '',
        'retired_at' => '',
        'notes' => '',
    ];

    public array $familyDoctor = [
        'id' => 0,
        'name' => '',
    ];

    public array $firmSubDivision = [
        'id' => 0,
        'name' => '',
    ];

    public array $firmWorkPlace = [
        'id' => 0,
        'name' => '',
    ];

    public array $firmPosition = [
        'id' => 0,
        'name' => '',
    ];

    public string $jobDuration = '';

    public string $careerDuration = '';

    public string $retirementDuration = '';

    protected function rules(): array
    {
        return [
            'item.first_name' => 'required|string|min:3',
            'item.second_name' => '',
            'item.last_name' => 'required|string|min:3',
            'item.gender' => 'required',
            'item.id_number' => [
                'required',
                'string',
                'min:10',
                function (string $attribute, ?string $value, callable $fail) {
                    $exists = Worker::query()
                        ->where('firm_id', $this->firmId)
                        ->where('id_number', $value)
                        ->when($this->workerId > 0, function (Builder $query) {
                            $query->where('id', '!=', $this->workerId);
                        })->count() > 0;
                    if ($exists) {
                        $fail('Има друг работещ със същия ЕГН/ЛНЧ.');
                    }
                },
            ],
            'item.birth_date' => [
                'required',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    try {
                        $birthDate = Carbon::createFromFormat('d.m.Y', $value);
                        if ($birthDate->diffInYears(now()) < 18) {
                            $fail('Работещият не може да бъде под 18 г.');
                        } elseif ($birthDate->diffInYears(now()) > 80) {
                            $fail('Работещият не може да бъде под 80 г.');
                        }
                    } catch (Exception $ex) {
                        //
                    }
                },
            ],
            'item.address' => '',
            'item.phone1' => '',
            'item.phone2' => '',
            'item.job_start_at' => [
                'nullable',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value)) {
                        try {
                            $jobStartAt = Carbon::createFromFormat('d.m.Y', $value);
                            if ($jobStartAt->isAfter(now())) {
                                $fail('Датата не може да е по-късно от днес.');
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
            'item.career_start_at' => [
                'nullable',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value)) {
                        try {
                            $careerStartAt = Carbon::createFromFormat('d.m.Y', $value);
                            if ($careerStartAt->isAfter(now())) {
                                $fail('Датата не може да е по-късно от днес.');
                            } elseif (! empty($this->item['job_start_at'])) {
                                $jobStartAt = Carbon::createFromFormat('d.m.Y', $this->item['job_start_at']);
                                if ($careerStartAt->isAfter($jobStartAt)) {
                                    $fail('Датата е след началото на натроящата длъжност.');
                                }
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
            'item.retired_at' => [
                'nullable',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value)) {
                        try {
                            $retiredAt = Carbon::createFromFormat('d.m.Y', $value);
                            if ($retiredAt->isAfter(now())) {
                                $fail('Датата не може да е по-късно от днес.');
                            } elseif (! empty($this->item['career_start_at'])) {
                                $careerStartAt = Carbon::createFromFormat('d.m.Y', $this->item['career_start_at']);
                                if ($retiredAt->isBefore($careerStartAt)) {
                                    $fail('Датата на напускане е преди настоящия тр. стаж.');
                                }
                            } elseif (! empty($this->item['job_start_at'])) {
                                $jobStartAt = Carbon::createFromFormat('d.m.Y', $this->item['job_start_at']);
                                if ($retiredAt->isBefore($jobStartAt)) {
                                    $fail('Датата на напускане е преди общия трудов стаж.');
                                }
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
            'item.notes' => '',
        ];
    }

    protected $validationAttributes = [
        'item.first_name' => 'Име',
        'item.second_name' => 'Презиме',
        'item.last_name' => 'Фамилия',
        'item.gender' => 'Пол',
        'item.id_number' => 'ЕГН/ЛНЧ',
        'item.birth_date' => 'Дата на раждане',
        'item.address' => 'Дата на раждане',
        'item.phone1' => 'Тел. 1',
        'item.phone2' => 'Тел. 2',
        'item.job_start_at' => 'Тр. стаж по настоящата длъжност',
        'item.career_start_at' => 'Общ трудов стаж',
        'item.retired_at' => 'Напуснал',
        'item.notes' => 'Бележки',
    ];

    public function mount(int $firmId, int $workerId = 0): void
    {
        $this->firmId = $firmId;
        if (! empty($workerId) && $worker = Worker::where('firm_id', $firmId)->find($workerId)) {
            $this->workerId = $workerId;

            $this->item = [
                'first_name' => $worker->first_name,
                'second_name' => $worker->second_name,
                'last_name' => $worker->last_name,
                'gender' => $worker->gender,
                'id_number' => $worker->id_number,
                'birth_date' => ! empty($worker->birth_date) ? $worker->birth_date->format('d.m.Y') : '',
                'address' => $worker->address,
                'phone1' => $worker->phone1,
                'phone2' => $worker->phone2,
                'job_start_at' => ! empty($worker->job_start_at) ? $worker->job_start_at->format('d.m.Y') : '',
                'career_start_at' => ! empty($worker->career_start_at) ? $worker->career_start_at->format('d.m.Y') : '',
                'retired_at' => ! empty($worker->retired_at) ? $worker->retired_at->format('d.m.Y') : '',
                'notes' => $worker->notes,
            ];

            $this->familyDoctor = [
                'id' => $worker->family_doctor_id ?? 0,
                'name' => $worker->familyDoctor->name ?? '',
            ];

            $this->firmSubDivision = [
                'id' => $worker->firmStructure->firm_sub_division_id ?? 0,
                'name' => $worker->firmStructure->firmSubDivision->name ?? '',
            ];

            $this->firmWorkPlace = [
                'id' => $worker->firmStructure->firm_work_place_id ?? 0,
                'name' => $worker->firmStructure->firmWorkPlace->name ?? '',
            ];

            $this->firmPosition = [
                'id' => $worker->firmStructure->firm_position_id ?? 0,
                'name' => $worker->firmStructure->firmPosition->name ?? '',
            ];

            $this->jobDuration = $this->getDuration($worker->job_start_at);
            $this->careerDuration = $this->getDuration($worker->career_start_at);
            $this->retirementDuration = $this->getRetirementDuration();
        }
    }

    public function render(): View
    {
        return view('livewire.workers.form');
    }

    public function save(): void
    {
        $this->validate();

        $firmService = app(FirmService::class);

        $familyDoctorId = ! empty($this->familyDoctor['id'])
            ? FamilyDoctor::firstOrCreate(
                ['id' => $this->familyDoctor['id']],
                ['name' => $this->familyDoctor['name']]
            )->id : null;

        $firmStructureId = $firmService->getStructureIdOrCreate(
            $this->firmId,
            $this->firmSubDivision['name'],
            $this->firmWorkPlace['name'],
            $this->firmPosition['name'],
        );

        $data = array_merge($this->item, [
            'family_doctor_id' => $familyDoctorId,
            'firm_structure_id' => $firmStructureId,
        ]);

        if ($worker = Worker::find($this->workerId)) {
            $worker->update($data);

            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'message' => 'Информацията бе съхранена успешно.',
            ]);

        } else {
            $worker = Worker::create(array_merge($data, [
                'firm_id' => $this->firmId
            ]));

            session()->flash('message', 'Работещият бе добавен успешно.');

            $this->redirectRoute('firms.workers.edit', ['firm' => $this->firmId, 'worker' => $worker->id]);
        }
    }

    public function updated(string $name, mixed $value): void
    {
        if (in_array($name, ['item.job_start_at', 'item.career_start_at', 'item.retired_at'])) {
            $jobStartAt = null;
            if (! empty($this->item['job_start_at'])) {
                try {
                    $jobStartAt = Carbon::createFromFormat('d.m.Y', $this->item['job_start_at']);
                } catch (Exception $ex) {
                    //
                }
            }

            $careerStartAt = null;
            if (! empty($this->item['career_start_at'])) {
                try {
                    $careerStartAt = Carbon::createFromFormat('d.m.Y', $this->item['career_start_at']);
                } catch (Exception $ex) {
                    //
                }
            }

            $this->careerDuration = $this->getDuration($careerStartAt);
            $this->jobDuration = $this->getDuration($jobStartAt);
            $this->retirementDuration = $this->getRetirementDuration();
        } elseif ('item.id_number' === $name && ! empty($value) && 10 === strlen((string) $value)) {
            try {
                $bgEgnService = new BgEgnService($value);

                if (empty($this->item['gender'])) {
                    $this->item['gender'] = ! $bgEgnService->getSex() ? 'm' : 'f';
                }

                if (empty($this->item['birth_date'])) {
                    $this->item['birth_date'] = sprintf('%02d.%02d.%04d',
                        $bgEgnService->getDay(),
                        $bgEgnService->getMonth(),
                        $bgEgnService->getYear()
                    );
                }
            } catch (Exception $ex) {
                //
            }
        }
    }

    private function getRetirementDuration(): string
    {
        $workStartDate = null;
        if (! empty($this->item['career_start_at'])) {
            try {
                $workStartDate = Carbon::createFromFormat('d.m.Y', $this->item['career_start_at']);
            } catch (Exception $ex) {
                //
            }
        }
        if (empty($workStartDate) && ! empty($this->item['job_start_at'])) {
            try {
                $workStartDate = Carbon::createFromFormat('d.m.Y', $this->item['job_start_at']);
            } catch (Exception $ex) {
                //
            }
        }

        return $this->getDuration($workStartDate);
    }

    private function getDuration(?Carbon $startDate = null): string
    {
        if (empty($startDate)) {
            return '';
        }

        $mm = $startDate->diffInMonths();
        $yy = floor($mm / 12);
        $mm -= $yy * 12;

        return $yy.' г. и '.$mm.' м.';
    }
}
