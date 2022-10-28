<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FirmPosition;
use App\Models\FirmStructure;
use App\Models\FirmSubDivision;
use App\Models\FirmWorkPlace;

class FirmService
{
    public function getStructureIdOrCreate(
        int $firmId,
        ?string $firmSubDivisionName,
        ?string $firmWorkPlaceName,
        ?string $firmPositionName): int
    {
        $firmSubDivision = ! empty($firmSubDivisionName)
            ? FirmSubDivision::where('firm_id', $firmId)
                ->firstOrCreate(
                    ['name' => $firmSubDivisionName, 'firm_id' => $firmId],
                    ['position' => FirmSubDivision::where('firm_id', $firmId)->count() + 1]
                ) : null;

        $firmWorkPlace = ! empty($firmWorkPlaceName)
            ? FirmWorkPlace::where('firm_id', $firmId)
                ->firstOrCreate(
                    ['name' => $firmWorkPlaceName, 'firm_id' => $firmId],
                    ['position' => FirmWorkPlace::where('firm_id', $firmId)->count() + 1]
                ) : null;

        $firmPosition = ! empty($firmPositionName)
            ? FirmPosition::where('firm_id', $firmId)
                ->firstOrCreate(
                    ['name' => $firmPositionName, 'firm_id' => $firmId],
                    ['position' => FirmPosition::where('firm_id', $firmId)->count() + 1]
                ) : null;

        $firmStructure = FirmStructure::firstOrCreate(
            [
                'firm_id' => $firmId,
                'firm_sub_division_id' => $firmSubDivision->id ?? null,
                'firm_work_place_id' => $firmWorkPlace->id ?? null,
                'firm_position_id' => $firmPosition->id ?? null,
            ]
        );

        return $firmStructure->id;
    }
}
