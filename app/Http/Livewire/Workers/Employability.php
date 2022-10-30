<?php

namespace App\Http\Livewire\Workers;

use App\Models\MkbCode;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Employability extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public array $item = [
        'employabilities' => [],
    ];

    protected $rules = [
        'item.employabilities.*.published_at' => 'required|date_format:d.m.Y',
        'item.employabilities.*.mkb_code' => 'required|exists:mkb_codes,code',
    ];

    protected $validationAttributes = [
        'item.employabilities.*.published_at' => 'Дата',
        'item.employabilities.*.mkb_code_id' => 'МКБ'
    ];

    protected $listeners = ['deleteEmployability'];

    public function mount(int $firmId, int $workerId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;

        $this->item = $this->loadData($this->workerId);


    }

    public function render(): View
    {
        return view('livewire.workers.employability');
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            DB::table('employabilities')
                ->where('worker_id', $this->workerId)
                ->delete();

            if (!empty($this->item['employabilities'])) {
                foreach ($this->item['employabilities'] as $i => $employability) {
                    $mkbCodeId = null;
                    if (!empty($employability['mkb_code']) && $mkbCode = MkbCode::where('code', $employability['mkb_code'])->first()) {
                        $mkbCodeId = $mkbCode->id;
                    }

                    $data = [
                        'worker_id' => $this->workerId,
                        'published_at' => !empty($employability['published_at'])
                            ? Carbon::createFromFormat('d.m.Y', $employability['published_at']) : null,
                        'mkb_code_id' => $mkbCodeId,
                        'diagnosis' => $employability['diagnosis'],
                        'authorities' => $employability['authorities'],
                        'start_date' => !empty($employability['start_date'])
                            ? Carbon::createFromFormat('d.m.Y', $employability['start_date']) : null,
                        'end_date' => !empty($employability['end_date'])
                            ? Carbon::createFromFormat('d.m.Y', $employability['end_date']) : null,
                        'employability_place' => $employability['employability_place'],
                        'position' => $i + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    if (!empty($employability['id'])) {
                        $data['id'] = $employability['id'];
                    }

                    DB::table('employabilities')->insert($data);
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
        $this->item['employabilities'][] = [
            'id' => null,
            'published_at' => '',
            'mkb_code' => '',
            'diagnosis' => '',
            'authorities' => '',
            'start_date' => '',
            'end_date' => '',
            'employability_place' => ''
        ];

        $this->dispatchBrowserEvent('attach-autocomplete');
    }

    public function confirmDelete(int $index): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете записа?',
            'id' => $index,
            'listener' => 'deleteEmployability',
        ]);
    }

    public function deleteEmployability(int $index): void
    {
        if (isset($this->item['employabilities'][$index])) {
            unset($this->item['employabilities'][$index]);
        }
        $this->item['employabilities'] = array_values($this->item['employabilities']);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    private function loadData(int $workerId): array
    {
        return [
            'employabilities' => Worker::findOrFail($workerId)->employabilities()->with('mkbCode')->get()
                ->map(function (\App\Models\Employability $employability) {
                    return [
                        'id' => $employability->id,
                        'published_at' => !empty($employability->published_at) ? $employability->published_at->format('d.m.Y') : '',
                        'mkb_code' => $employability->mkbCode?->code,
                        'diagnosis' => $employability->diagnosis,
                        'authorities' => $employability->authorities,
                        'start_date' => !empty($employability->start_date) ? $employability->start_date->format('d.m.Y') : '',
                        'end_date' => !empty($employability->end_date) ? $employability->end_date->format('d.m.Y') : '',
                        'employability_place' => $employability->employability_place,
                    ];
                }),
        ];
    }
}
