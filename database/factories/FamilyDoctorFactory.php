<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyDoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'dr. '.fake()->name,
            'address' => fake()->address(),
            'phone1' => fake()->phoneNumber(),
            'phone2' => fake()->phoneNumber(),
        ];
    }
}
