<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientChartTypeSeeder extends Seeder
{
    public function run(): void
    {
        $patientChartTypes = DB::connection('old')
            ->table('chart_types')
            ->orderBy('type_id')
            ->get();

        foreach ($patientChartTypes as $i => $patientChartType) {
            DB::table('patient_chart_types')->insert([
                'id' => $patientChartType->type_id,
                'name' => $patientChartType->type_desc,
                'position' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
