<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Firm;
use App\Models\MkbCode;
use App\Models\PatientChartReason;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientChartSeeder extends Seeder
{
    public function run(): void
    {
        $patientCharts = DB::connection('old')
            ->table('patient_charts')
            ->get();

        DB::table('patient_chart_type')->delete();
        DB::table('patient_charts')->delete();

        $firmIds = Firm::pluck('id')->toArray();

        $mkbCodes = [];
        $patientChartReasons = [];
        foreach ($patientCharts as $patientChart) {
            if (! in_array($patientChart->firm_id, $firmIds)) {
                continue;
            }

            if (! isset($mkbCodes[$patientChart->mkb_id])) {
                if ($mkbCode = MkbCode::where('code', $patientChart->mkb_id)->first()) {
                    $mkbCodes[$patientChart->mkb_id] = $mkbCode->id;
                }
            }

            if (! isset($patientChartReasons[$patientChart->reason_id])) {
                if ($patientChartReason = PatientChartReason::where('code', $patientChart->reason_id)->first()) {
                    $patientChartReasons[$patientChart->reason_id] = $patientChartReason->id;
                }
            }

            try {
                DB::table('patient_charts')->insert([
                    'id' => $patientChart->chart_id,
                    'firm_id' => $patientChart->firm_id,
                    'worker_id' => $patientChart->worker_id,
                    'reg_num' => $patientChart->chart_num,
                    'start_date' => $patientChart->hospital_date_from,
                    'end_date' => $patientChart->hospital_date_to,
                    'days_off' => $patientChart->days_off,
                    'mkb_code_id' => $mkbCodes[$patientChart->mkb_id] ?? null,
                    'patient_chart_reason_id' => $patientChartReasons[$patientChart->reason_id] ?? null,
                    'notes' => ! empty($patientChart->chart_desc) ? $patientChart->chart_desc : null,
                    'created_at' => $patientChart->date_added,
                    'updated_at' => $patientChart->date_modified,
                ]);

                if (! empty($patientChart->medical_types)) {
                    $patientChartTypeIds = unserialize($patientChart->medical_types);
                    foreach ($patientChartTypeIds as $patientChartTypeId) {
                        DB::table('patient_chart_type')->insert([
                            'patient_chart_id' => $patientChart->chart_id,
                            'patient_chart_type_id' => $patientChartTypeId,
                            'created_at' => $patientChart->date_added,
                            'updated_at' => $patientChart->date_modified,
                        ]);
                    }
                }
            } catch (Exception $ex) {
                // $this->command->error($ex->getMessage());
            }
        }
    }
}
