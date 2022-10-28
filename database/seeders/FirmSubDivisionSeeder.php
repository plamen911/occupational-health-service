<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirmSubDivisionSeeder extends Seeder
{
    public function run(): void
    {
        $subdivisions = DB::connection('old')
            ->table('subdivisions')
            ->get();

        foreach ($subdivisions as $subdivision) {
            try {
                DB::table('firm_sub_divisions')->insert([
                    'id' => $subdivision->subdivision_id,
                    'firm_id' => $subdivision->firm_id,
                    'name' => cleanText($subdivision->subdivision_name),
                    'description' => null,
                    'position' => $subdivision->subdivision_position,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                //$this->command->error($ex->getMessage());
            }
        }
    }
}
