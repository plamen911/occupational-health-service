<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirmStructureSeeder extends Seeder
{
    public function run(): void
    {
        $firmStructures = DB::connection('old')
            ->table('firm_struct_map')
            ->get();

        $this->command->getOutput()->progressStart($firmStructures->count());

        foreach ($firmStructures as $firmStructure) {
            try {
                DB::table('firm_structures')->insert([
                    'id' => $firmStructure->map_id,
                    'firm_id' => $firmStructure->firm_id,
                    'firm_sub_division_id' => $firmStructure->subdivision_id,
                    'firm_work_place_id' => $firmStructure->wplace_id,
                    'firm_position_id' => $firmStructure->position_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                //
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
