<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoryResearchSeeder extends Seeder
{
    public function run(): void
    {
        $laboratoryResearches = DB::connection('old')
            ->table('lab_checkups')
            ->get();

        DB::table('laboratory_researches')->delete();

        $this->command->getOutput()->progressStart($laboratoryResearches->count());

        foreach ($laboratoryResearches as $laboratoryResearch) {
            try {
                DB::table('laboratory_researches')->insert([
                    'id' => $laboratoryResearch->lab_checkup_id,
                    'prophylactic_checkup_id' => $laboratoryResearch->checkup_id,
                    'laboratory_indicator_id' => $laboratoryResearch->indicator_id,
                    'type' => $laboratoryResearch->checkup_type,
                    'value' => $laboratoryResearch->checkup_level,
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
