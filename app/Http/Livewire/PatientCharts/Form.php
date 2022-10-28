<?php

declare(strict_types=1);

namespace App\Http\Livewire\PatientCharts;

use App\Models\MkbCode;
use App\Models\PatientChart;
use App\Models\PatientChartReason;
use App\Models\Worker;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public array $item = [
        'id' => null,
        'worker_id' => '',
        'firm_id' => '',
        'id_number' => '',
        'reg_num' => '',
        'worker_name' => '',
        'start_date' => '',
        'end_date' => '',
        'days_off' => '',
        'mkb_code' => '',
        'mkb_desc' => '',
        'patient_chart_reason_id' => '',
        'patient_chart_types' => [],
        'notes' => '',
        'patient_charts' => [],
    ];

    public $patientChartReasonDropdown = [];

    protected function rules(): array
    {
        return [
            'item.id' => '',
            'item.id_number' => 'required|string|min:3',
            'item.reg_num' => 'required',
            'item.worker_name' => 'required',
            'item.start_date' => [
                'required',
                'date_format:d.m.Y',
                function (string $attribute, ?string $value, callable $fail) {
                    if (! empty($value) && ! empty($this->item['end_date'])) {
                        try {
                            $startDate = Carbon::createFromFormat('d.m.Y', $value);
                            $endDate = Carbon::createFromFormat('d.m.Y', $this->item['end_date']);
                            if ($startDate->isAfter($endDate)) {
                                $fail('Началната дата не може да е по-късно от крайната.');
                            }
                        } catch (Exception $ex) {
                            //
                        }
                    }
                },
            ],
            'item.end_date' => 'required|date_format:d.m.Y',
            'item.days_off' => 'required',
            'item.mkb_code' => 'required',
            'item.patient_chart_reason_id' => 'required|exists:patient_chart_reasons,id',
            'item.notes' => '',
        ];
    }

    protected $validationAttributes = [
        'item.id_number' => 'ЕГН/ЛНЧ',
        'item.reg_num' => 'Болничен лист №',
        'item.worker_name' => 'Име',
        'item.start_date' => 'От дата',
        'item.end_date' => 'До дата',
        'item.days_off' => 'ВН',
        'item.mkb_code' => 'МКБ',
        'item.patient_chart_reason_id' => 'Причина',
        'item.notes' => 'Разширена диагноза',
    ];

    protected $listeners = ['deletePatientChart'];

    public function mount(int $firmId = 0, int $workerId = 0): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;

        if ($firmId > 0 && $workerId > 0) {
            $this->item = $this->loadData($this->workerId);
        }

        $this->patientChartReasonDropdown = PatientChartReason::dropdown()->toArray();
    }

    public function render(): View
    {
        return view('livewire.patient-charts.form');
    }

    public function save(): void
    {
        $this->validate();

        $mkbCode = MkbCode::where('code', $this->item['mkb_code'])->firstOrFail();
        $patientChartReason = PatientChartReason::findOrFail($this->item['patient_chart_reason_id']);

        $data = [
            'reg_num' => $this->item['reg_num'],
            'start_date' => $this->item['start_date'],
            'end_date' => $this->item['end_date'],
            'days_off' => $this->item['days_off'],
            'mkb_code_id' => $mkbCode->id,
            'patient_chart_reason_id' => $patientChartReason->id,
            'notes' => ! empty($this->item['notes']) ? trim($this->item['notes']) : null,
        ];

        if ($patientChart = PatientChart::find($this->item['id'])) {
            $patientChart->update($data);
        } else {
            $patientChart = PatientChart::create(array_merge($data, [
                'firm_id' => $this->item['firm_id'],
                'worker_id' => $this->item['worker_id'],
            ]));
        }

        $patientChart->patientChartTypes()->sync(array_filter($this->item['patient_chart_types'] ?? []));

        $this->item = $this->loadData($this->workerId);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Информацията бе съхранена успешно.',
        ]);
    }

    public function addPatientChart(int $workerId): void
    {
        $this->item = $this->loadData($workerId);
    }

    public function editPatientChart(PatientChart $patientChart): void
    {
        $this->item = $this->loadData($patientChart->worker_id, $patientChart->id);
    }

    public function updated(string $name, mixed $value): void
    {
        if (in_array($name, ['item.start_date', 'item.end_date'])) {
            if (! empty($this->item['start_date']) && ! empty($this->item['end_date'])) {
                try {
                    $startDate = Carbon::createFromFormat('d.m.Y', $this->item['start_date']);
                    $endDate = Carbon::createFromFormat('d.m.Y', $this->item['end_date']);
                    $this->item['days_off'] = $endDate->diffInDays($startDate);
                } catch (Exception $ex) {
                    //
                }
            }
        }
    }

    public function confirmDelete(PatientChart $prophylacticCheckup): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете болничния лист?',
            'id' => $prophylacticCheckup->id,
            'listener' => 'deletePatientChart',
        ]);
    }

    public function deletePatientChart(PatientChart $patientChart): void
    {
        $patientChart->delete();

        $this->item = $this->loadData($this->workerId);

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    private function loadData(int $workerId, int $patientChartId = 0): array
    {
        $worker = Worker::findOrFail($workerId);

        $this->reset('item');

        $this->item['firm_id'] = $this->firmId;
        $this->item['worker_id'] = $worker->id;
        $this->item['id_number'] = $worker->id_number;
        $this->item['worker_name'] = $worker->full_name;
        $this->item['patient_charts'] = PatientChart::with(['mkbCode', 'patientChartReason', 'patientChartTypes'])
            ->where('worker_id', $worker->id)
            ->orderBy('start_date')
            ->get()
            ->map(function (PatientChart $patientChart) {
                return [
                    'id' => $patientChart->id,
                    'reg_num' => $patientChart->reg_num,
                    'start_date' => ! empty($patientChart->start_date) ? $patientChart->start_date->format('d.m.Y') : '',
                    'end_date' => ! empty($patientChart->end_date) ? $patientChart->end_date->format('d.m.Y') : '',
                    'days_off' => $patientChart->days_off,
                    'mkb_code' => $patientChart->mkbCode?->code,
                    'mkb_desc' => $patientChart->mkbCode?->name,
                    'patient_chart_reason' => $patientChart->mkbCode?->code,
                    'patient_chart_types' => $patientChart->patientChartTypes?->pluck('name'),
                    //'patient_chart_types' => $patientChart->patientChartTypes,
                ];
            })
            ->toArray();

        if ($patientChartId > 0 && $patientChart = PatientChart::where('worker_id', $workerId)->findOrFail($patientChartId)) {
            $this->item['id'] = $patientChart->id;
            $this->item['reg_num'] = $patientChart->reg_num;
            $this->item['start_date'] = ! empty($patientChart->start_date) ? $patientChart->start_date->format('d.m.Y') : '';
            $this->item['end_date'] = ! empty($patientChart->end_date) ? $patientChart->end_date->format('d.m.Y') : '';
            $this->item['days_off'] = $patientChart->days_off;
            $this->item['mkb_code'] = $patientChart->mkbCode?->code;
            $this->item['mkb_desc'] = $patientChart->mkbCode?->name;
            $this->item['patient_chart_reason_id'] = $patientChart->patient_chart_reason_id;
            $this->item['patient_chart_types'] = DB::table('patient_chart_type')
                ->where('patient_chart_id', $patientChart->id)
                ->pluck('patient_chart_type_id')
                ->toArray();
            $this->item['notes'] = $patientChart->notes;
        }

        return $this->item;
    }
}
