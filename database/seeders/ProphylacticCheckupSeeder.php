<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CheckupPlace;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProphylacticCheckupSeeder extends Seeder
{
    public function run(): void
    {
        $medicalCheckups = DB::connection('old')
            ->table('medical_checkups')
            ->get();

        foreach ($medicalCheckups as $medicalCheckup) {
            $hearingLossId = null;
            switch ($medicalCheckup->hearing_loss) {
                case 'Приемна':
                    $hearingLossId = 1;
                    break;

                case 'Проводна':
                    $hearingLossId = 2;
                    break;

                case 'Смесена':
                    $hearingLossId = 3;
                    break;
            }

            $checkupDate = null;
            if (! empty($medicalCheckup->checkup_date)) {
                try {
                    $checkupDate = Carbon::parse($medicalCheckup->checkup_date);
                } catch (Exception $ex) {
                    //
                }
            }

            $ohsDate = null;
            if (! empty($medicalCheckup->stm_date)) {
                try {
                    $ohsDate = Carbon::parse($medicalCheckup->stm_date);
                } catch (Exception $ex) {
                    //
                }
            }

            try {
                DB::table('prophylactic_checkups')->insert([
                    'id' => $medicalCheckup->checkup_id,
                    'firm_id' => $medicalCheckup->firm_id,
                    'worker_id' => $medicalCheckup->worker_id,
                    'checkup_num' => $medicalCheckup->PregledNo,
                    'checkup_date' => $checkupDate,
                    'worker_height' => (float) $medicalCheckup->worker_height,
                    'worker_weight' => (float) $medicalCheckup->worker_weight,
                    'rr_systolic' => (int) $medicalCheckup->rr_syst,
                    'rr_diastolic' => (int) $medicalCheckup->rr_diast,
                    'is_smoking' => (int) $medicalCheckup->smoking,
                    'is_drinking' => (int) $medicalCheckup->drinking,
                    'has_bad_nutrition' => (int) $medicalCheckup->fats,
                    'in_on_diet' => (int) $medicalCheckup->diet,
                    'has_home_stress' => (int) $medicalCheckup->home_stress,
                    'has_work_stress' => (int) $medicalCheckup->work_stress,
                    'has_social_stress' => (int) $medicalCheckup->social_stress,
                    'has_long_screen_time' => (int) $medicalCheckup->video_display,
                    'sport_hours' => (int) $medicalCheckup->hours_activity,
                    'has_low_activity' => (int) $medicalCheckup->low_activity,
                    'left_eye' => (float) $medicalCheckup->left_eye,
                    'left_eye2' => (float) $medicalCheckup->left_eye2,
                    'right_eye' => (float) $medicalCheckup->right_eye,
                    'right_eye2' => (float) $medicalCheckup->right_eye2,
                    'breath_vk' => (float) $medicalCheckup->VK,
                    'breath_feo' => (float) $medicalCheckup->FEO1,
                    'breath_tifno' => (float) $medicalCheckup->tifno,
                    'hearing_loss_id' => $hearingLossId,
                    'left_ear' => (float) $medicalCheckup->left_ear,
                    'right_ear' => (float) $medicalCheckup->right_ear,
                    'tone_audiometry' => ! empty($medicalCheckup->hearing_diagnose) ? $medicalCheckup->hearing_diagnose : null,
                    'electrocardiogram' => ! empty($medicalCheckup->EKG) ? $medicalCheckup->EKG : null,
                    'x_ray' => ! empty($medicalCheckup->x_ray) ? $medicalCheckup->x_ray : null,
                    'echo_ray' => ! empty($medicalCheckup->echo_ray) ? $medicalCheckup->echo_ray : null,
                    'family_medical_history' => ! empty($medicalCheckup->fweights_descr) ? $medicalCheckup->fweights_descr : null,
                    'medical_history' => ! empty($medicalCheckup->anamnesis_descr) ? $medicalCheckup->anamnesis_descr : null,
                    'ohs_conclusion_id' => ! empty($medicalCheckup->stm_conclusion) ? $medicalCheckup->stm_conclusion : null,
                    'ohs_conditions' => ! empty($medicalCheckup->stm_conditions) ? $medicalCheckup->stm_conditions : null,
                    'ohs_date' => $ohsDate,
                    'created_at' => $medicalCheckup->date_added,
                    'updated_at' => $medicalCheckup->date_modified,
                ]);

                $hospitals = null;
                if (! empty($medicalCheckup->hospitals)) {
                    // bug: it does not unserialize ut8 text properly - returns binary data
                    $hospitals = array_filter(unserialize($medicalCheckup->hospitals));
                    foreach ($hospitals as $hospital) {
                        if (! empty($hospital)) {
                            $checkupPlace = CheckupPlace::firstOrCreate([
                                'name' => $hospital,
                            ]);
                            DB::table('prophylactic_checkup_place')->insert([
                                'checkup_place_id' => $checkupPlace->id,
                                'prophylactic_checkup_id' => $medicalCheckup->checkup_id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            } catch (Exception $ex) {
                $this->command->info($ex->getMessage());
            }
        }
    }
}
