<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class WorkerController extends Controller
{
    public function index(Firm $firm): View
    {
        return view('workers.index', compact('firm'));
    }

    public function create(Firm $firm): View
    {
        $worker = new Worker();

        return view('workers.create', compact('firm', 'worker'));
    }

    public function edit(Firm $firm, Worker $worker, ?string $tab = null): View
    {
        abort_if($firm->id !== $worker->firm_id, Response::HTTP_BAD_REQUEST);

        if (empty($tab)) {
            $tab = 'form';
        }

        return view('workers.edit', compact('firm', 'worker', 'tab'));
    }
}
