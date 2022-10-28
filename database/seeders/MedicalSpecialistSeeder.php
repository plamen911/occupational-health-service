<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalSpecialistSeeder extends Seeder
{
    public function run(): void
    {
        $medicalSpecialists = DB::connection('old')->table('Specialists')->get();

        DB::table('medical_specialists')->delete();

        foreach ($medicalSpecialists as $medicalSpecialist) {
            DB::table('medical_specialists')->insert([
                'id' => $medicalSpecialist->SpecialistID,
                'name' => $medicalSpecialist->SpecialistName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $rows = DB::connection('old')
            ->table('medical_checkups_doctors2')
            ->orderBy('checkup_id')
            ->get();

        DB::table('medical_specialist_prophylactic_checkup')->delete();

        $this->command->getOutput()->progressStart($rows->count());

        $position = 1;
        $oldProphylacticCheckupId = null;

        foreach ($rows as $row) {
            try {
                if ($oldProphylacticCheckupId !== $row->checkup_id) {
                    $oldProphylacticCheckupId = $row->checkup_id;
                    $position = 1;
                }

                DB::table('medical_specialist_prophylactic_checkup')->insert([
                    'medical_specialist_id' => $row->SpecialistID,
                    'prophylactic_checkup_id' => $row->checkup_id,
                    'medical_opinion' => $row->conclusion,
                    'position' => $position++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                // $this->command->error($ex->getMessage());
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
