<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirmWorkPlaceSeeder extends Seeder
{
    public function run(): void
    {
        $workPlaces = DB::connection('old')
            ->table('work_places')
            ->get();

        foreach ($workPlaces as $workPlace) {
            try {
                DB::table('firm_work_places')->insert([
                    'id' => $workPlace->wplace_id,
                    'firm_id' => $workPlace->firm_id,
                    'name' => cleanText($workPlace->wplace_name),
                    'description' => ! empty($workPlace->wplace_workcond) ? cleanText($workPlace->wplace_workcond) : null,
                    'position' => $workPlace->wplace_position,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                //$this->command->error($ex->getMessage());
            }
        }
    }
}
