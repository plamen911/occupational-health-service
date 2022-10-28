<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Firm>
 */
class FirmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $author = User::all()->random(1)[0];

        return [
            'name' => fake()->company(),
            'manager' => fake()->name(),
            'address' => fake()->address(),
            'email' => fake()->email(),
            'phone1' => fake()->phoneNumber(),
            'phone2' => null,
            'notes' => fake()->sentence(10),
            'created_by' => $author->id,
            'updated_by' => $author->id,
        ];
    }
}
