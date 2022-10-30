<?php

declare(strict_types=1);

namespace App\View\Components\Workes;

use App\Models\Firm;
use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public Firm $firm;

    public ?Worker $worker = null;

    public function __construct(
        public int $firmId,
        public int $workerId = 0,
        public string $tab = 'form')
    {
        $this->firm = Firm::findOrFail($this->firmId);
        if (! empty($prophylacticCheckupId)) {
            $this->worker = Worker::findOrFail($this->workerId);
        }
    }

    public function render(): View
    {
        return view('components.workes.tabs');
    }
}
