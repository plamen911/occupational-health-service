<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\OhsConclusion;
use Illuminate\Database\Seeder;

class OhsConclusionSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'може',
            'може при сл. условия',
            'не може',
            'не може да се прецени пригодността на работещия',
        ];

        foreach ($names as $i => $name) {
            OhsConclusion::updateOrCreate(
                ['name' => $name],
                ['position' => $i + 1]
            );
        }
    }
}
