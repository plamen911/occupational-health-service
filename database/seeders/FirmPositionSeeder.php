<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirmPositionSeeder extends Seeder
{
    public function run(): void
    {
        $firmPositions = DB::connection('old')
            ->table('firm_positions')
            ->get();

        foreach ($firmPositions as $firmPosition) {
            try {
                DB::table('firm_positions')->insert([
                    'id' => $firmPosition->position_id,
                    'firm_id' => $firmPosition->firm_id,
                    'name' => cleanText($firmPosition->position_name),
                    'description' => ! empty($firmPosition->position_workcond) ? cleanText($firmPosition->position_workcond) : null,
                    'position' => $firmPosition->position_position,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                //$this->command->error($ex->getMessage());
            }
        }
    }
}
