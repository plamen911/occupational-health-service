<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\MkbCode;
use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Diagnoses extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'diagnoses' => [],
    ];

    protected $listeners = ['deleteDiagnosis'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $prophylacticCheckup = ProphylacticCheckup::where('worker_id', $workerId)
            ->findOrFail($prophylacticCheckupId);

        $this->item = [
            'diagnoses' => $prophylacticCheckup->diagnoses()
                ->with('mkbCode')
                ->get()
                ->map(function (\App\Models\Diagnosis $diagnosis) {
                    return [
                        'id' => $diagnosis->id,
                        'mkb_code' => $diagnosis->mkbCode?->code,
                        'mkb_desc' => $diagnosis->mkbCode?->name,
                        'diagnosis' => $diagnosis->diagnosis,
                        'is_new' => $diagnosis->is_new,
                    ];
                }),
        ];
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.diagnoses');
    }

    public function save(): void
    {
        DB::transaction(function () {
            DB::table('diagnoses')
                ->where('prophylactic_checkup_id', $this->prophylacticCheckupId)
                ->delete();

            if (! empty($this->item['diagnoses'])) {
                foreach ($this->item['diagnoses'] as $diagnosis) {
                    if ($mkbCode = MkbCode::where('code', $diagnosis['mkb_code'])->first()) {
                        $data = [
                            'prophylactic_checkup_id' => $this->prophylacticCheckupId,
                            'mkb_code_id' => $mkbCode->id,
                            'diagnosis' => $diagnosis['diagnosis'],
                            'is_new' => (int) $diagnosis['is_new'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        if (! empty($diagnosis['id'])) {
                            $data['id'] = $diagnosis['id'];
                        }

                        DB::table('diagnoses')->insert($data);
                    }
                }
            }

            $this->dispatchBrowserEvent('swal:toast', [
                'type' => 'success',
                'message' => 'Информацията бе съхранена успешно.',
            ]);
        });
    }

    public function addDiagnosis(): void
    {
        $this->item['diagnoses'][] = [
            'id' => null,
            'mkb_code' => '',
            'mkb_desc' => '',
            'diagnosis' => '',
            'is_new' => '0',
        ];

        $this->dispatchBrowserEvent('attach-autocomplete');
    }

    public function confirmDelete(int $index): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете диагнозата?',
            'id' => $index,
            'listener' => 'deleteDiagnosis',
        ]);
    }

    public function deleteDiagnosis(int $index): void
    {
        if (isset($this->item['diagnoses'][$index])) {
            unset($this->item['diagnoses'][$index]);
        }
        $this->item['diagnoses'] = array_values($this->item['diagnoses']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }
}
