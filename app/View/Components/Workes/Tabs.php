<?php

declare(strict_types=1);

namespace App\View\Components\Workes;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(public int $firmId, public int $workerId = 0)
    {
        //
    }

    public function render(): View
    {
        return view('components.workes.tabs');
    }
}
