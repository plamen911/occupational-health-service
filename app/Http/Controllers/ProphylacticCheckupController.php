<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\ProphylacticCheckup;
use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ProphylacticCheckupController extends Controller
{
    public function index(Firm $firm, Worker $worker): RedirectResponse
    {
        abort_if($firm->id !== $worker->firm_id, Response::HTTP_BAD_REQUEST);

        if ($lastProphylacticCheckup = $worker->prophylacticCheckups()->latest()->first()) {
            return redirect()->route('prophylactic-checkups.edit', [
                'firm' => $firm->id,
                'worker' => $worker->id,
                'prophylactic_checkup' => $lastProphylacticCheckup->id,
            ]);
        }

        return redirect()->route('prophylactic-checkups.create', [
            'firm' => $firm->id,
            'worker' => $worker->id,
        ]);
    }

    public function create(Firm $firm, Worker $worker): View
    {
        abort_if($firm->id !== $worker->firm_id, Response::HTTP_BAD_REQUEST);

        return view('prophylactic-checkups.create', compact('firm', 'worker'));
    }

    public function edit(Firm $firm, Worker $worker, ProphylacticCheckup $prophylacticCheckup, ?string $tab = null): View
    {
        abort_if($firm->id !== $worker->firm_id || $worker->id !== $prophylacticCheckup->worker_id, Response::HTTP_BAD_REQUEST);

        if (empty($tab)) {
            $tab = 'checkup1';
        }

        return view('prophylactic-checkups.edit', compact('firm', 'worker', 'prophylacticCheckup', 'tab'));
    }
}
