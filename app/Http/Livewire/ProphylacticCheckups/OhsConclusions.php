<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\OhsConclusion;
use App\Models\ProphylacticCheckup;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OhsConclusions extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'ohs_conclusion_id' => '',
        'ohs_conditions' => '',
        'ohs_date' => '',
    ];

    public bool $showConditions = false;

    public array $ohsConclusionDropdown = [];

    protected function rules(): array
    {
        return [
            'item.ohs_conclusion_id' => 'required|exists:ohs_conclusions,id',
            'item.ohs_conditions' => '',
            'item.ohs_date' => [
                'required',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value)) {
                        try {
                            $ohsDate = Carbon::createFromFormat('d.m.Y', $value);
                            if ($ohsDate->isAfter(now())) {
                                $fail('Датата не може да е по-късно от днес.');
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
        ];
    }

    protected $validationAttributes = [
        'item.ohs_conclusion_id' => 'Заключение на СТМ',
        'item.ohs_conditions' => 'Условия',
        'item.ohs_date' => 'Дата на изготвяне',
    ];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $this->item = $this->loadData($this->prophylacticCheckupId);

        $this->ohsConclusionDropdown = OhsConclusion::dropdown()->toArray();
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.ohs-conclusions');
    }

    public function save(): void
    {
        $this->validate();

        ProphylacticCheckup::findOrFail($this->prophylacticCheckupId)
            ->update([
                'ohs_conclusion_id' => $this->item['ohs_conclusion_id'],
                'ohs_conditions' => $this->showConditions ? $this->item['ohs_conditions'] : '',
                'ohs_date' => $this->item['ohs_date'],
            ]);

        $this->item = $this->loadData($this->prophylacticCheckupId);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }

    public function updated(string $name, mixed $value): void
    {
        if ('item.ohs_conclusion_id' === $name) {
            $this->showConditions = OhsConclusion::CONDITIONS_ID === (int) $value;
            if (! $this->showConditions) {
                $this->item['ohs_conditions'] = '';
            }
        }
    }

    private function loadData(int $prophylacticCheckupId): array
    {
        $prophylacticCheckup = ProphylacticCheckup::findOrFail($prophylacticCheckupId);

        $this->showConditions = OhsConclusion::CONDITIONS_ID === $prophylacticCheckup->ohs_conclusion_id;

        return [
            'ohs_conclusion_id' => $prophylacticCheckup->ohs_conclusion_id,
            'ohs_conditions' => $prophylacticCheckup->ohs_conditions,
            'ohs_date' => ! empty($prophylacticCheckup->ohs_date)
                ? $prophylacticCheckup->ohs_date->format('d.m.Y') : '',
        ];
    }
}
