<?php

declare(strict_types=1);

namespace App\Http\Livewire\Workers;

use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProfessionalExperience extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public array $item = [
        'professional_experiences' => [],
    ];

    protected $rules = [
        'item.professional_experiences.*.firm_name' => 'required',
        'item.professional_experiences.*.job_position' => 'required',
    ];

    protected $validationAttributes = [
        'item.professional_experiences.*.firm_name' => 'Предприятие',
        'item.professional_experiences.*.job_position' => 'Длъжностs'
    ];

    protected $listeners = ['deleteProfessionalExperience'];

    public function mount(int $firmId, int $workerId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;

        $this->item = $this->loadData($this->workerId);
    }

    public function render(): View
    {
        return view('livewire.workers.professional-experience');
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            DB::table('professional_experiences')
                ->where('worker_id', $this->workerId)
                ->delete();

            if (!empty($this->item['professional_experiences'])) {
                foreach ($this->item['professional_experiences'] as $i => $professionalExperience) {
                    $data = [
                        'worker_id' => $this->workerId,
                        'firm_name' => $professionalExperience['firm_name'],
                        'job_position' => $professionalExperience['job_position'],
                        'years_length' => (int)$professionalExperience['years_length'],
                        'months_length' => (int)$professionalExperience['months_length'],
                        'position' => $i + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    if (!empty($professionalExperience['id'])) {
                        $data['id'] = $professionalExperience['id'];
                    }

                    DB::table('professional_experiences')->insert($data);
                }
            }
        });

        $this->item = $this->loadData($this->workerId);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }

    public function addRecord(): void
    {
        $this->item['professional_experiences'][] = [
            'id' => null,
            'firm_name' => '',
            'job_position' => '',
            'years_length' => '',
            'months_length' => '',
        ];
    }

    public function confirmDelete(int $index): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете записа?',
            'id' => $index,
            'listener' => 'deleteProfessionalExperience',
        ]);
    }

    public function deleteProfessionalExperience(int $index): void
    {
        if (isset($this->item['professional_experiences'][$index])) {
            unset($this->item['professional_experiences'][$index]);
        }
        $this->item['professional_experiences'] = array_values($this->item['professional_experiences']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    private function loadData(int $workerId): array
    {
        return [
            'professional_experiences' => Worker::findOrFail($workerId)->professionalExperiences()->get()
                ->map(function (\App\Models\ProfessionalExperience $professionalExperience) {
                    return [
                        'id' => $professionalExperience->id,
                        'firm_name' => $professionalExperience->firm_name,
                        'job_position' => $professionalExperience->job_position,
                        'years_length' => $professionalExperience->years_length,
                        'months_length' => $professionalExperience->months_length,
                    ];
                }),
        ];
    }
}
