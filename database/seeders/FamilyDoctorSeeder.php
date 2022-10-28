<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyDoctorSeeder extends Seeder
{
    public function run(): void
    {
        $familyDoctors = DB::connection('old')
            ->table('doctors')
            ->get();

        foreach ($familyDoctors as $familyDoctor) {
            try {
                DB::table('family_doctors')->insert([
                    'id' => $familyDoctor->doctor_id,
                    'name' => cleanText($familyDoctor->doctor_name),
                    'address' => ! empty($familyDoctor->address) ? cleanText($familyDoctor->address) : null,
                    'phone1' => ! empty($familyDoctor->phone1) ? cleanText($familyDoctor->phone1) : null,
                    'phone2' => ! empty($familyDoctor->phone2) ? cleanText($familyDoctor->phone2) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Exception $ex) {
                //
            }
        }
    }
}
