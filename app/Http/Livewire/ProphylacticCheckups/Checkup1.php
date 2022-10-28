<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\ProphylacticCheckup;
use App\Models\Worker;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Checkup1 extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public ?string $prophylacticCheckupId = '';

    public array $item = [
        'checkup_num' => '',
        'checkup_date' => '',
        'worker_height' => 0.0,
        'worker_weight' => 0.0,
        'rr_systolic' => 0.0,
        'rr_diastolic' => 0.0,
        'is_smoking' => 0,
        'is_drinking' => 0,
        'has_bad_nutrition' => 0,
        'in_on_diet' => 0,
        'has_home_stress' => 0,
        'has_work_stress' => 0,
        'has_social_stress' => 0,
        'has_long_screen_time' => 0,
        'sport_hours' => 0.0,
        'has_low_activity' => 0,
    ];

    protected function rules(): array
    {
        return [
            'item.checkup_num' => 'required',
            'item.checkup_date' => [
                'required',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value)) {
                        try {
                            $checkupDate = Carbon::createFromFormat('d.m.Y', $value);
                            if ($checkupDate->isAfter(now())) {
                                $fail('Датата не може да е по-късно от днес.');
                            } else {
                                if (ProphylacticCheckup::query()
                                    ->where('firm_id', $this->firmId)
                                    ->where('worker_id', $this->workerId)
                                    ->where('checkup_date', $checkupDate->format('Y-m-d'))
                                    ->when(! empty($this->prophylacticCheckupId), function (Builder $query) {
                                        $query->where('id', '!=', $this->prophylacticCheckupId);
                                    })->exists()) {
                                    $fail('Има друга профилактична карта със същата дата.');
                                }
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
            'item.worker_height' => '',
            'item.worker_weight' => '',
            'item.rr_systolic' => '',
            'item.rr_diastolic' => '',
            'item.is_smoking' => '',
            'item.is_drinking' => '',
            'item.has_bad_nutrition' => '',
            'item.in_on_diet' => '',
            'item.has_home_stress' => '',
            'item.has_work_stress' => '',
            'item.has_social_stress' => '',
            'item.has_long_screen_time' => '',
            'item.sport_hours' => '',
            'item.has_low_activity' => '',
        ];
    }

    protected $validationAttributes = [
        'item.checkup_num' => 'Преглед №',
        'item.checkup_date' => 'Дата',
        'item.worker_height' => 'Ръст',
        'item.worker_weight' => 'Тегло',
        'item.rr_systolic' => 'RR сист.',
        'item.rr_diastolic' => 'RR диаст.',
        'item.is_smoking' => 'Тютюнопушене',
        'item.is_drinking' => 'Алкохол',
        'item.has_bad_nutrition' => 'Нерационално хранене',
        'item.in_on_diet' => 'Диета',
        'item.has_home_stress' => 'Стрес в дома',
        'item.has_work_stress' => 'Стрес в работата',
        'item.has_social_stress' => 'Социален стрес',
        'item.has_long_screen_time' => 'ВИДЕОДИСПЛЕЙ повече от 1/2 от раб. време',
        'item.sport_hours' => 'Физическа активност / часа',
        'item.has_low_activity' => 'Намалена двигателна активност',
    ];

    protected $listeners = ['deleteProphylacticCheckup'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId = 0): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;

        $prophylacticCheckup = null;

        if (! empty($prophylacticCheckupId) && $prophylacticCheckup = ProphylacticCheckup::where('worker_id', $workerId)->find($prophylacticCheckupId)) {
            $this->prophylacticCheckupId = (string) $prophylacticCheckupId;

            $this->item = array_merge($this->item, [
                'checkup_num' => $prophylacticCheckup->checkup_num,
                'checkup_date' => ! empty($prophylacticCheckup->checkup_date) ? $prophylacticCheckup->checkup_date->format('d.m.Y') : '',
            ]);
        }

        if (empty($prophylacticCheckup)) {
            // get info from last prophylactic checkup
            $prophylacticCheckup = ProphylacticCheckup::where('worker_id', $workerId)->orderByDesc('checkup_date')->first();
        }

        if (! empty($prophylacticCheckup)) {
            $this->item = array_merge($this->item, [
                'worker_height' => $prophylacticCheckup->worker_height,
                'worker_weight' => $prophylacticCheckup->worker_weight,
                'rr_systolic' => $prophylacticCheckup->rr_systolic,
                'rr_diastolic' => $prophylacticCheckup->rr_diastolic,
                'is_smoking' => $prophylacticCheckup->is_smoking,
                'is_drinking' => $prophylacticCheckup->is_drinking,
                'has_bad_nutrition' => $prophylacticCheckup->has_bad_nutrition,
                'in_on_diet' => $prophylacticCheckup->in_on_diet,
                'has_home_stress' => $prophylacticCheckup->has_home_stress,
                'has_work_stress' => $prophylacticCheckup->has_work_stress,
                'has_social_stress' => $prophylacticCheckup->has_social_stress,
                'has_long_screen_time' => $prophylacticCheckup->has_long_screen_time,
                'sport_hours' => $prophylacticCheckup->sport_hours,
                'has_low_activity' => $prophylacticCheckup->has_low_activity,
            ]);
        }
    }

    public function render(): View
    {
        $prophylacticCheckupDropdown = Worker::findOrFail($this->workerId)
            ->prophylacticCheckups()
            ->orderByDesc('checkup_date')
            ->pluck('checkup_date', 'id');

        return view('livewire.prophylactic-checkups.checkup1', [
            'prophylacticCheckupDropdown' => $prophylacticCheckupDropdown,
        ]);
    }

    public function save(): void
    {
        $this->validate();

        $data = array_merge($this->item, [
            'firm_id' => $this->firmId,
            'worker_id' => $this->workerId,
        ]);

        if (! empty($this->prophylacticCheckupId)) {
            ProphylacticCheckup::findOrFail($this->prophylacticCheckupId)->update($data);

            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'message' => 'Информацията бе съхранена успешно.',
            ]);
        } else {
            $prophylacticCheckup = ProphylacticCheckup::create($data);

            $this->redirectRoute('prophylactic-checkups.edit', [
                'firm' => $this->firmId,
                'worker' => $this->workerId,
                'prophylactic_checkup' => $prophylacticCheckup->id,
            ]);
        }
    }

    public function updated(string $name, string $value): void
    {
        if ('prophylacticCheckupId' === $name) {
            if (empty($value)) {
                $this->redirectRoute('prophylactic-checkups.create', [
                    'firm' => $this->firmId,
                    'worker' => $this->workerId,
                ]);
            } else {
                $this->redirectRoute('prophylactic-checkups.edit', [
                    'firm' => $this->firmId,
                    'worker' => $this->workerId,
                    'prophylactic_checkup' => (int) $value,
                ]);
            }
        }
    }

    public function confirmDelete(ProphylacticCheckup $prophylacticCheckup): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете профилактичната карта?',
            'id' => $prophylacticCheckup->id,
            'listener' => 'deleteProphylacticCheckup',
        ]);
    }

    public function deleteProphylacticCheckup(ProphylacticCheckup $prophylacticCheckup): void
    {
        $prophylacticCheckup->delete();

        // go to the last checkup
        $lastProphylacticCheckup = ProphylacticCheckup::where('worker_id', $this->workerId)->orderByDesc('checkup_date')->first();
        if ($lastProphylacticCheckup) {
            $this->redirectRoute('prophylactic-checkups.edit', [
                'firm' => $this->firmId,
                'worker' => $this->workerId,
                'prophylactic_checkup' => $lastProphylacticCheckup->id,
            ]);
        } else {
            $this->redirectRoute('prophylactic-checkups.create', [
                'firm' => $this->firmId,
                'worker' => $this->workerId,
            ]);
        }
    }
}
