<?php

declare(strict_types=1);

namespace App\Traits;

trait WithSortable
{
    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = ! $this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }
}
