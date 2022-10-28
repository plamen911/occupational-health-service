<?php

declare(strict_types=1);

namespace App\Http\Livewire\ProphylacticCheckups;

use App\Models\MedicalSpecialist;
use App\Models\ProphylacticCheckup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MedicalOpinions extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public int $prophylacticCheckupId = 0;

    public array $item = [
        'medical_opinions' => [],
    ];

    public array $medicalSpecialistDropdown = [];

    protected $listeners = ['deleteMedicalOpinion'];

    public function mount(int $firmId, int $workerId, int $prophylacticCheckupId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;
        $this->prophylacticCheckupId = $prophylacticCheckupId;

        $this->item = $this->loadData($this->prophylacticCheckupId);

        $this->medicalSpecialistDropdown = MedicalSpecialist::dropdown()->toArray();
    }

    public function render(): View
    {
        return view('livewire.prophylactic-checkups.medical-opinions');
    }

    public function save(): void
    {
        DB::transaction(function () {
            DB::table('medical_specialist_prophylactic_checkup')
                ->where('prophylactic_checkup_id', $this->prophylacticCheckupId)
                ->delete();

            if (! empty($this->item['medical_opinions'])) {
                $existing = [];
                $position = 1;
                foreach ($this->item['medical_opinions'] as $medicalOpinion) {
                    if (! empty($medicalOpinion['id']) && ! isset($existing[$medicalOpinion['id']])) {
                        $existing[$medicalOpinion['id']] = $medicalOpinion['id'];

                        DB::table('medical_specialist_prophylactic_checkup')->insert([
                            'medical_specialist_id' => $medicalOpinion['id'],
                            'prophylactic_checkup_id' => $this->prophylacticCheckupId,
                            'medical_opinion' => $medicalOpinion['medical_opinion'],
                            'position' => $position++,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
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

    public function addMedicalOpinion(): void
    {
        $this->item['medical_opinions'][] = [
            'id' => null,
            'name' => '',
            'medical_opinion' => '',
        ];
    }

    public function confirmDelete(int $index): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете заключението?',
            'id' => $index,
            'listener' => 'deleteMedicalOpinion',
        ]);
    }

    public function deleteMedicalOpinion(int $index): void
    {
        if (isset($this->item['medical_opinions'][$index])) {
            unset($this->item['medical_opinions'][$index]);
        }
        $this->item['medical_opinions'] = array_values($this->item['medical_opinions']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    private function loadData(int $prophylacticCheckupId): array
    {
        $prophylacticCheckup = ProphylacticCheckup::findOrFail($prophylacticCheckupId);

        return [
            'medical_opinions' => $prophylacticCheckup->medicalSpecialists()
                ->get()
                ->map(function (MedicalSpecialist $medicalSpecialist) {
                    return [
                        'id' => $medicalSpecialist->id,
                        'name' => $medicalSpecialist->name,
                        'medical_opinion' => $medicalSpecialist->pivot?->medical_opinion,
                    ];
                })
                ->toArray(),
        ];
    }
}
