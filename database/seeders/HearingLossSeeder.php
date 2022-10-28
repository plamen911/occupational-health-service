<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HearingLoss;
use Illuminate\Database\Seeder;

class HearingLossSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Приемна',
            'Проводна',
            'Смесена',
        ];

        foreach ($names as $i => $name) {
            HearingLoss::updateOrCreate(
                ['name' => $name],
                ['position' => $i + 1]
            );
        }
    }
}
