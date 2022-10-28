<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FamilyDoctor;
use App\Models\Firm;
use App\Models\FirmStructure;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function definition(): array
    {
        $firm = Firm::inRandomOrder()->firstOrFail();
        $birthDate = now()->subYears(random_int(20, 60))->subMonths(random_int(0, 12));
        $jobStartAt = now()->subYears(random_int(1, 20))->subMonths(random_int(0, 12));
        $careerStartAt = $jobStartAt->subYears(random_int(1, 10))->subMonths(random_int(0, 12));

        return [
            'firm_id' => $firm->id,
            'first_name' => fake()->firstName(),
            'second_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'gender' => ['m', 'f'][random_int(0, 1)],
            'id_number' => $birthDate->format('ymd').fake()->numberBetween(1000, 9999),
            'birth_date' => $birthDate,
            'address' => fake()->address,
            'email' => fake()->email,
            'phone1' => fake()->phoneNumber(),
            'phone2' => null,
            //'firm_structure_id' => FirmStructure::where('firm_id', $firm->id)->inRandomOrder()->firstOrFail()->id,
            'family_doctor_id' => FamilyDoctor::inRandomOrder()->firstOrFail()->id,
            'job_start_at' => $jobStartAt,
            'career_start_at' => $careerStartAt,
            'retired_at' => null,
            'notes' => fake()->sentence(100),
        ];
    }
}
