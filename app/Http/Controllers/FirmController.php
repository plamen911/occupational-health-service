<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Firm;
use Illuminate\Contracts\View\View;

class FirmController extends Controller
{
    public function index(): View
    {
        return view('firms.index');
    }

    public function create(): View
    {
        $firm = new Firm();

        return view('firms.create', compact('firm'));
    }

    public function edit(Firm $firm): View
    {
        return view('firms.edit', compact('firm'));
    }
}
