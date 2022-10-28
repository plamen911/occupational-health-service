<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\Worker;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class PatientChartController extends Controller
{
    public function __invoke(Firm $firm, Worker $worker): View
    {
        abort_if($firm->id !== $worker->firm_id, Response::HTTP_BAD_REQUEST);

        return view('patient-charts.index', compact('firm', 'worker'));
    }
}
