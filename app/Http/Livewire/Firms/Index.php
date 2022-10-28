<?php

declare(strict_types=1);

namespace App\Http\Livewire\Firms;

use App\Models\Firm;
use App\Traits\WithSortable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithSortable, AuthorizesRequests;

    public string $sortBy = 'firms.name';

    public bool $sortAsc = true;

    public string $q = '';

    public int $perPage = 20;

    protected $listeners = [
        'deleteFirm',
        'refresh' => '$refresh',
    ];

    public function render(): View
    {
        $firms = $this->query()
            ->withCount('workers')
            ->when($this->q, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('firms.name', 'like', '%'.$this->q.'%')
                        ->orWhere('firms.address', 'like', '%'.$this->q.'%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->perPage);

        return view('livewire.firms.index', [
            'firms' => $firms,
        ]);
    }

    public function query(): Builder
    {
        return Firm::query();
    }

    public function confirmDelete(Firm $firm): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Моля, потвърдете',
            'text' => 'Наистина ли искате да изтриете данните за фирмата?',
            'id' => $firm->id,
            'listener' => 'deleteFirm',
        ]);
    }

    public function deleteFirm(Firm $firm): void
    {
        $firm->delete();

        $this->dispatchBrowserEvent('swal:toast', [
            'type' => 'success',
            'message' => 'Данните бяха успешно изтрити.',
        ]);
    }

    public function addFirm(): void
    {
        $this->redirectRoute('firms.create');
    }
}
