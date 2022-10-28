<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MkbGroupSeeder extends Seeder
{
    public function run(): void
    {
        $mkbGroups = DB::connection('old')
            ->table('mkb_groups')
            ->get();

        foreach ($mkbGroups as $mkbGroup) {
            try {
                DB::table('mkb_groups')->insert([
                    'id' => $mkbGroup->group_id,
                    'class_id' => $mkbGroup->class_id,
                    'name' => $mkbGroup->group_name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                $this->command->error($ex->getMessage());
            }
        }
    }
}
