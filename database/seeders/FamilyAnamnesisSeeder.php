<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MkbCode;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyAnamnesisSeeder extends Seeder
{
    public function run(): void
    {
        $familyAnamneses = DB::connection('old')
            ->table('family_weights')
            ->get();

        $mkbCodeMapping = [];

        foreach ($familyAnamneses as $familyAnamnesis) {
            if (empty($familyAnamnesis->mkb_id)) {
                continue;
            }

            if (! isset($mkbCodeMapping[$familyAnamnesis->mkb_id])) {
                $mkbCode = MkbCode::where('code', $familyAnamnesis->mkb_id)->firstOrFail();
                $mkbCodeMapping[$familyAnamnesis->mkb_id] = $mkbCode->id;
            }

            try {
                DB::table('family_anamneses')->insert([
                    'id' => $familyAnamnesis->family_weight_id,
                    'prophylactic_checkup_id' => $familyAnamnesis->checkup_id,
                    'mkb_code_id' => $mkbCodeMapping[$familyAnamnesis->mkb_id],
                    'diagnosis' => $familyAnamnesis->diagnosis,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                $this->command->error($ex->getMessage());
            }
        }
    }
}
