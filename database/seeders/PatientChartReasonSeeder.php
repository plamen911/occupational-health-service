<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientChartReasonSeeder extends Seeder
{
    public function run(): void
    {
        $patientChartReasons = DB::connection('old')
            ->table('medical_reasons')
            ->orderBy('reason_id')
            ->get();

        foreach ($patientChartReasons as $i => $patientChartReason) {
            DB::table('patient_chart_reasons')->insert([
                'code' => $patientChartReason->reason_id,
                'name' => $patientChartReason->reason_desc,
                'position' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
