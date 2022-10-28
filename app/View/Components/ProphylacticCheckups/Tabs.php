<?php

declare(strict_types=1);

namespace App\View\Components\ProphylacticCheckups;

use App\Models\Firm;
use App\Models\ProphylacticCheckup;
use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public Firm $firm;

    public Worker $worker;

    public ?ProphylacticCheckup $prophylacticCheckup = null;

    public function __construct(
        public int $firmId,
        public int $workerId,
        public int $prophylacticCheckupId = 0,
        public string $tab = 'checkup1')
    {
        $this->firm = Firm::findOrFail($this->firmId);
        $this->worker = Worker::findOrFail($this->workerId);
        if (! empty($prophylacticCheckupId)) {
            $this->prophylacticCheckup = ProphylacticCheckup::findOrFail($this->prophylacticCheckupId);
        }
    }

    public function render(): View
    {
        return view('components.prophylactic-checkups.tabs');
    }
}
