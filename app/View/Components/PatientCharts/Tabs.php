<?php

declare(strict_types=1);

namespace App\View\Components\PatientCharts;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(public int $firmId, public ?int $workerId)
    {
        //
    }

    public function render(): View
    {
        return view('components.patient-charts.tabs');
    }
}
