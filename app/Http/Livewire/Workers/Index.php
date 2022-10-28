<?php

declare(strict_types=1);

namespace App\Http\Livewire\Workers;

use App\Models\Firm;
use App\Models\Worker;
use App\Traits\WithSortable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithSortable, AuthorizesRequests;

    public string $sortBy = 'workers.first_name';

    public bool $sortAsc = true;

    public string $q = '';

    public int $perPage = 20;

    public Firm $firm;

    protected $listeners = [
        'deleteWorker',
        'refresh' => '$refresh',
    ];

    public function render(): View
    {
        $workers = $this->query()
            ->with(['firmStructure.firmPosition'])
            ->withCount(['prophylacticCheckups', 'patientCharts'])
            ->when($this->q, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('workers.first_name', 'like', '%'.$this->q.'%')
                        ->orWhere('workers.second_name', 'like', '%'.$this->q.'%')
                        ->orWhere('workers.last_name', 'like', '%'.$this->q.'%')
                        ->orWhere('workers.id_number', 'like', $this->q.'%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->perPage);

        return view('livewire.workers.index', [
            'workers' => $workers,
        ]);
    }

    public function query(): Builder
    {
        return Worker::query()->where('firm_id', $this->firm->id);
    }

    public function confirmDelete(Worker $worker): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете данните за работещия?',
            'id' => $worker->id,
            'listener' => 'deleteWorker',
        ]);
    }

    public function deleteWorker(Worker $worker): void
    {
        $worker->delete();

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    public function addWorker(Firm $firm): void
    {
        $this->redirectRoute('firms.workers.create', $firm->id);
    }
}
