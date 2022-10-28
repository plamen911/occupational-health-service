<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            FirmSeeder::class,
            FirmSubDivisionSeeder::class,
            FirmWorkPlaceSeeder::class,
            FirmPositionSeeder::class,
            FirmStructureSeeder::class,
            FamilyDoctorSeeder::class,
            WorkerSeeder::class,
            HearingLossSeeder::class,
            OhsConclusionSeeder::class,
            ProphylacticCheckupSeeder::class,
            MkbClassSeeder::class,
            MkbGroupSeeder::class,
            MkbCodeSeeder::class,
            FamilyAnamnesisSeeder::class,
            AnamnesisSeeder::class,
            DiagnosisSeeder::class,
            LaboratoryIndicatorSeeder::class,
            LaboratoryResearchSeeder::class,
            MedicalSpecialistSeeder::class,
            PatientChartReasonSeeder::class,
            PatientChartTypeSeeder::class,
            PatientChartSeeder::class,

        ]);
    }
}
