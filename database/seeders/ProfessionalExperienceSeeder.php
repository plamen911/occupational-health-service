<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalExperienceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('professional_experiences')->delete();

        $professionalExperiences = DB::connection('old')
            ->table('pro_route')
            ->orderBy('worker_id')
            ->orderBy('id')
            ->get();

        $oldWorkerId = null;
        $position = 1;

        foreach ($professionalExperiences as $professionalExperience) {
            try {
                if ($oldWorkerId !== $professionalExperience->worker_id) {
                    $oldWorkerId = $professionalExperience->worker_id;
                    $position = 1;
                }

                DB::table('professional_experiences')->insert([
                    'id' => $professionalExperience->route_id,
                    'worker_id' => $professionalExperience->worker_id,
                    'firm_name' => $professionalExperience->firm_name,
                    'job_position' => $professionalExperience->position,
                    'years_length' => $professionalExperience->exp_length_y,
                    'months_length' => $professionalExperience->exp_length_m,
                    'position' => $position++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            } catch (Exception $ex) {
                // $this->command->error($ex->getMessage());
            }
        }
    }
}
