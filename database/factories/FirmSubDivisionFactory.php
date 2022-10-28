<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Firm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FirmSubDivision>
 */
class FirmSubDivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'firm_id' => null,
            'name' => fake()->company(),
            'description' => fake()->text(100),
        ];
    }
}
