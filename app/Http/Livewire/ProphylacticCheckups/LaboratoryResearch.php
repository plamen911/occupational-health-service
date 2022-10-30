<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\LaboratoryIndicator;
use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LaboratoryResearch extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'laboratory_researches' => [],
    ];

    public array $laboratoryIndicatorDropdown = [];

    protected $rules = [
        'item.laboratory_researches.*.laboratory_indicator_id' => 'required|exists:laboratory_indicators,id',
    ];

    protected $validationAttributes = [
        'item.laboratory_researches.*.laboratory_indicator_id' => 'Показател',
    ];

    protected $listeners = ['deleteLaboratoryResearch'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $this->item = $this->loadData($this->prophylacticCheckupId);

        $this->laboratoryIndicatorDropdown = LaboratoryIndicator::dropdown()->toArray();
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.laboratory-research');
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            DB::table('laboratory_researches')
                ->where('prophylactic_checkup_id', $this->prophylacticCheckupId)
                ->delete();

            if (! empty($this->item['laboratory_researches'])) {
                $existing = [];
                foreach ($this->item['laboratory_researches'] as $laboratoryResearch) {
                    if (! empty($laboratoryResearch['laboratory_indicator_id']) && ! isset($existing[$laboratoryResearch['laboratory_indicator_id']])) {
                        $existing[$laboratoryResearch['laboratory_indicator_id']] = $laboratoryResearch['laboratory_indicator_id'];

                        $data = [
                            'prophylactic_checkup_id' => $this->prophylacticCheckupId,
                            'laboratory_indicator_id' => $laboratoryResearch['laboratory_indicator_id'],
                            'type' => $laboratoryResearch['type'],
                            'value' => $laboratoryResearch['value'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        if (! empty($laboratoryResearch['id'])) {
                            $data['id'] = $laboratoryResearch['id'];
                        }

                        DB::table('laboratory_researches')->insert($data);
                    }
                }
            }
        });

        $this->item = $this->loadData($this->prophylacticCheckupId);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }

    public function addLaboratoryResearch(): void
    {
        $this->item['laboratory_researches'][] = [
            'id' => null,
            'laboratory_indicator_id' => '',
            'type' => '',
            'value' => '',
            'min_value' => '',
            'max_value' => '',
            'dimension' => '',
            'deviation' => '',
        ];
    }

    public function confirmDelete(int $index): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете изследването?',
            'id' => $index,
            'listener' => 'deleteLaboratoryResearch',
        ]);
    }

    public function deleteLaboratoryResearch(int $index): void
    {
        if (isset($this->item['laboratory_researches'][$index])) {
            unset($this->item['laboratory_researches'][$index]);
        }
        $this->item['laboratory_researches'] = array_values($this->item['laboratory_researches']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    public function updated(string $name, mixed $value): void
    {
        if (preg_match('/item\.laboratory_researches\.(\d+)\.laboratory_indicator_id/m', $name, $m)) {
            $idx = (int) $m[1];
            if (isset($this->item['laboratory_researches'][$idx])) {
                $val = $this->item['laboratory_researches'][$idx]['value'] ?? '';
                $minValue = $this->item['laboratory_researches'][$idx]['min_value'] ?? '';
                $maxValue = $this->item['laboratory_researches'][$idx]['max_value'] ?? '';
                $dimension = $this->item['laboratory_researches'][$idx]['dimension'] ?? '';
                $deviation = $this->item['laboratory_researches'][$idx]['deviation'] ?? '';

                if ($laboratoryIndicator = LaboratoryIndicator::find($value)) {
                    $minValue = (float) $laboratoryIndicator->min_value;
                    $maxValue = (float) $laboratoryIndicator->max_value;
                    $dimension = $laboratoryIndicator->dimension;
                    $deviation = $this->getDeviation($value, $minValue, $maxValue);
                }
                $this->item['laboratory_researches'][$idx] = array_merge($this->item['laboratory_researches'][$idx], [
                    'laboratory_indicator_id' => ! empty($value) ? (int) $value : null,
                    'value' => $val,
                    'min_value' => $minValue,
                    'max_value' => $maxValue,
                    'dimension' => $dimension,
                    'deviation' => $deviation,
                ]);
            }
        }
    }

    private function getDeviation(mixed $value, float $minValue, float $maxValue): string
    {
        if (empty($value) || ! is_numeric($value)) {
            return '';
        }

        if (round((float) $value, 2) < round($minValue, 2)) {
            return 'down';
        }

        if (round((float) $value, 2) > round($maxValue, 2)) {
            return 'up';
        }

        return '';
    }

    private function loadData(int $prophylacticCheckupId): array
    {
        $prophylacticCheckup = ProphylacticCheckup::findOrFail($prophylacticCheckupId);

        return [
            'laboratory_researches' => $prophylacticCheckup->laboratoryResearches()
                ->with('laboratoryIndicator')
                ->get()
                ->map(function (\App\Models\LaboratoryResearch $laboratoryResearch) {
                    $minValue = (float) $laboratoryResearch->laboratoryIndicator?->min_value;
                    $maxValue = (float) $laboratoryResearch->laboratoryIndicator?->max_value;

                    return [
                        'id' => $laboratoryResearch->id,
                        'laboratory_indicator_id' => $laboratoryResearch->laboratory_indicator_id,
                        'type' => $laboratoryResearch->type,
                        'value' => $laboratoryResearch->value,
                        'min_value' => $minValue,
                        'max_value' => $maxValue,
                        'dimension' => $laboratoryResearch->laboratoryIndicator?->dimension,
                        'deviation' => $this->getDeviation($laboratoryResearch->value, $minValue, $maxValue),
                    ];
                }),
        ];
    }
}
