<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MkbCode;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosisSeeder extends Seeder
{
    public function run(): void
    {
        $diagnoses = DB::connection('old')
            ->table('family_diseases')
            ->get();

        DB::table('diagnoses')->delete();

        $mkbCodeMapping = [];

        foreach ($diagnoses as $diagnosis) {
            if (empty($diagnosis->mkb_id)) {
                continue;
            }

            if (! isset($mkbCodeMapping[$diagnosis->mkb_id])) {
                $mkbCode = MkbCode::where('code', $diagnosis->mkb_id)->first();
                if (! $mkbCode) {
                    continue;
                }

                $mkbCodeMapping[$diagnosis->mkb_id] = $mkbCode->id;
            }

            try {
                DB::table('diagnoses')->insert([
                    'id' => $diagnosis->disease_id,
                    'prophylactic_checkup_id' => $diagnosis->checkup_id,
                    'mkb_code_id' => $mkbCodeMapping[$diagnosis->mkb_id],
                    'diagnosis' => $diagnosis->diagnosis,
                    'is_new' => (int) $diagnosis->is_new,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                // $this->command->error($ex->getMessage());
            }
        }
    }
}
