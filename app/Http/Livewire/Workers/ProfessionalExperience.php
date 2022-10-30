<?php

declare(strict_types=1);

namespace App\Http\Livewire\Workers;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProfessionalExperience extends Component
{
    public int $firmId = 0;

    public int $workerId = 0;

    public array $item = [];

    protected function rules(): array
    {
        return [];
    }

    protected $validationAttributes = [];

    public function mount(int $firmId, int $workerId): void
    {
        $this->firmId = $firmId;
        $this->workerId = $workerId;

    }

    public function render(): View
    {
        return view('livewire.workers.professional-experience');
    }

    public function save(): void
    {
        $this->validate();

    }
}
