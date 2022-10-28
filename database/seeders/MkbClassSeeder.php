<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MkbClassSeeder extends Seeder
{
    public function run(): void
    {
        $mkbClasses = DB::connection('old')
            ->table('mkb_classes')
            ->get();

        foreach ($mkbClasses as $mkbClass) {
            DB::table('mkb_classes')->insert([
                'id' => $mkbClass->class_id,
                'name' => $mkbClass->class_name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
