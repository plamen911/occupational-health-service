<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoryIndicatorSeeder extends Seeder
{
    public function run(): void
    {
        $laboratoryIndicators = DB::connection('old')->table('lab_indicators')->get();

        DB::table('laboratory_indicators')->delete();

        foreach ($laboratoryIndicators as $laboratoryIndicator) {
            DB::table('laboratory_indicators')->insert([
                'type' => $laboratoryIndicator->indicator_type,
                'name' => $laboratoryIndicator->indicator_name,
                'min_value' => (float) $laboratoryIndicator->pdk_min,
                'max_value' => (float) $laboratoryIndicator->pdk_max,
                'dimension' => $laboratoryIndicator->indicator_dimension,
                'position' => $laboratoryIndicator->indicator_position,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
