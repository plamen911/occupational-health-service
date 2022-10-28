<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\MkbCode;
use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Anamnesis extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'medical_history' => '',
        'anamneses' => [],
    ];

    protected $listeners = ['deleteAnamnesis'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $prophylacticCheckup = ProphylacticCheckup::where('worker_id', $workerId)
            ->findOrFail($prophylacticCheckupId);

        $this->item = [
            'medical_history' => $prophylacticCheckup->medical_history,
            'anamneses' => $prophylacticCheckup->anamneses()
                ->with('mkbCode')
                ->get()
                ->map(function (\App\Models\Anamnesis $anamnesis) {
                    return [
                        'id' => $anamnesis->id,
                        'mkb_code' => $anamnesis->mkbCode?->code,
                        'mkb_desc' => $anamnesis->mkbCode?->name,
                        'diagnosis' => $anamnesis->diagnosis,
                    ];
                }),
        ];
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.anamnesis');
    }

    public function save(): void
    {
        ProphylacticCheckup::findOrFail($this->prophylacticCheckupId)
            ->update([
                'medical_history' => $this->item['medical_history'],
            ]);

        DB::transaction(function () {
            DB::table('anamneses')
                ->where('prophylactic_checkup_id', $this->prophylacticCheckupId)
                ->delete();

            if (! empty($this->item['anamneses'])) {
                foreach ($this->item['anamneses'] as $anamnese) {
                    if ($mkbCode = MkbCode::where('code', $anamnese['mkb_code'])->first()) {
                        $data = [
                            'prophylactic_checkup_id' => $this->prophylacticCheckupId,
                            'mkb_code_id' => $mkbCode->id,
                            'diagnosis' => $anamnese['diagnosis'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        if (! empty($anamnese['id'])) {
                            $data['id'] = $anamnese['id'];
                        }

                        DB::table('anamneses')->insert($data);
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
        $this->item['anamneses'][] = [
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
            'listener' => 'deleteAnamnesis',
        ]);
    }

    public function deleteAnamnesis(int $index): void
    {
        if (isset($this->item['anamneses'][$index])) {
            unset($this->item['anamneses'][$index]);
        }
        $this->item['anamneses'] = array_values($this->item['anamneses']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }
}
