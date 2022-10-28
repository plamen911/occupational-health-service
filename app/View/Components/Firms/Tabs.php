<?php

declare(strict_types=1);

namespace App\View\Components\Firms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(public int $firmId = 0)
    {
        //
    }

    public function render(): View
    {
        return view('components.firms.tabs');
    }
}
