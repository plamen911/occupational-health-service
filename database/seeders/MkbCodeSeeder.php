<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MkbCodeSeeder extends Seeder
{
    public function run(): void
    {
        $mkbCodes = DB::connection('old')
            ->table('mkb')
            ->get();

        $this->command->getOutput()->progressStart($mkbCodes->count());

        foreach ($mkbCodes as $mkbCode) {
            try {
                DB::table('mkb_codes')->insert([
                    'group_id' => ! empty($mkbCode->group_id) ? $mkbCode->group_id : null,
                    'code' => $mkbCode->mkb_id,
                    'name' => $mkbCode->mkb_desc,
                    'edition' => $mkbCode->mkb_code,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                $this->command->error($ex->getMessage());
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
