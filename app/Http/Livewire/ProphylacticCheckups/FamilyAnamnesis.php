<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\MkbCode;
use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FamilyAnamnesis extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'family_medical_history' => '',
        'family_anamneses' => [],
    ];

    protected $listeners = ['deleteFamilyAnamnesis'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $prophylacticCheckup = ProphylacticCheckup::where('worker_id', $workerId)
            ->findOrFail($prophylacticCheckupId);

        $this->item = [
            'family_medical_history' => $prophylacticCheckup->family_medical_history,
            'family_anamneses' => $prophylacticCheckup->familyAnamneses()
                ->with('mkbCode')
                ->get()
                ->map(function (\App\Models\FamilyAnamnesis $familyAnamnesis) {
                    return [
                        'id' => $familyAnamnesis->id,
                        'mkb_code' => $familyAnamnesis->mkbCode?->code,
                        'mkb_desc' => $familyAnamnesis->mkbCode?->name,
                        'diagnosis' => $familyAnamnesis->diagnosis,
                    ];
                }),
        ];
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.family-anamnesis');
    }

    public function save(): void
    {
        ProphylacticCheckup::findOrFail($this->prophylacticCheckupId)
            ->update([
                'family_medical_history' => $this->item['family_medical_history'],
            ]);

        DB::transaction(function () {
            DB::table('family_anamneses')
                ->where('prophylactic_checkup_id', $this->prophylacticCheckupId)
                ->delete();

            if (! empty($this->item['family_anamneses'])) {
                foreach ($this->item['family_anamneses'] as $familyAnamnese) {
                    if ($mkbCode = MkbCode::where('code', $familyAnamnese['mkb_code'])->first()) {
                        $data = [
                            'prophylactic_checkup_id' => $this->prophylacticCheckupId,
                            'mkb_code_id' => $mkbCode->id,
                            'diagnosis' => $familyAnamnese['diagnosis'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        if (! empty($familyAnamnese['id'])) {
                            $data['id'] = $familyAnamnese['id'];
                        }

                        DB::table('family_anamneses')->insert($data);
                    }
                }
            }
        });

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }

    public function addDiagnosis(): void
    {
        $this->item['family_anamneses'][] = [
            'id' => null,
            'mkb_code' => '',
            'mkb_desc' => '',
            'diagnosis' => '',
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
            'listener' => 'deleteFamilyAnamnesis',
        ]);
    }

    public function deleteFamilyAnamnesis(int $index): void
    {
        if (isset($this->item['family_anamneses'][$index])) {
            unset($this->item['family_anamneses'][$index]);
        }
        $this->item['family_anamneses'] = array_values($this->item['family_anamneses']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }
}
