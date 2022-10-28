<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FamilyDoctor;
use App\Models\FirmPosition;
use App\Models\FirmSubDivision;
use App\Models\FirmWorkPlace;
use App\Models\MkbCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AutocompleteController extends Controller
{
    public function __invoke(Request $request, string $action): JsonResponse
    {
        $validated = $request->validate([
            'term' => 'required',
        ]);

        $term = $validated['term'];

        switch ($action) {
            case 'mkb-code':
                $term = $this->cyr2latMapper(Str::upper($term));

                $familyDoctors = MkbCode::query()
                    ->where('edition', 'МКБ 10')
                    ->where('code', 'like', $term.'%')
                    ->where(function (Builder $query) use ($term) {
                        $query->where(function (Builder $query) use ($term) {
                            $query->where('code', 'like', $term.'%')
                                ->orWhere('name', 'like', '%'.$term.'%');
                        });
                    })
                    ->orderBy('code')
                    ->offset(0)
                    ->limit(50)
                    ->get()
                    ->map(fn (MkbCode $mkbCode) => [
                        'id' => $mkbCode->id,
                        'value' => $mkbCode->code,
                        'label' => $mkbCode->code,
                        'desc' => $mkbCode->name,
                    ]);

                return response()->json($familyDoctors);

            case 'family-doctors':
                $familyDoctors = FamilyDoctor::query()
                    ->where('name', 'like', '%'.$term.'%')
                    ->orderBy('name')
                    ->offset(0)
                    ->limit(50)
                    ->get()
                    ->map(fn (FamilyDoctor $familyDoctor) => [
                        'id' => $familyDoctor->id,
                        'value' => $familyDoctor->name,
                        'label' => Str::limit($familyDoctor->name, 40),
                    ]);

                return response()->json($familyDoctors);

            case 'firm-sub-divisions':
                $firmSubDivisions = FirmSubDivision::query()
                    ->where('name', 'like', '%'.$term.'%')
                    ->when($request->firm_id, function (Builder $query) use ($request) {
                        $query->where('firm_id', $request->firm_id);
                    })
                    ->orderBy('name')
                    ->offset(0)
                    ->limit(50)
                    ->get()
                    ->map(fn (FirmSubDivision $firmSubDivision) => [
                        'id' => $firmSubDivision->id,
                        'value' => $firmSubDivision->name,
                        'label' => Str::limit($firmSubDivision->name, 40),
                    ]);

                return response()->json($firmSubDivisions);

            case 'firm-work-places':
                $firmWorkPlaces = FirmWorkPlace::query()
                    ->where('name', 'like', '%'.$term.'%')
                    ->when($request->firm_id, function (Builder $query) use ($request) {
                        $query->where('firm_id', $request->firm_id);
                    })
                    ->orderBy('name')
                    ->offset(0)
                    ->limit(50)
                    ->get()
                    ->map(fn (FirmWorkPlace $firmWorkPlace) => [
                        'id' => $firmWorkPlace->id,
                        'value' => $firmWorkPlace->name,
                        'label' => Str::limit($firmWorkPlace->name, 40),
                    ]);

                return response()->json($firmWorkPlaces);

            case 'firm-positions':
                $firmPositions = FirmPosition::query()
                    ->where('name', 'like', '%'.$term.'%')
                    ->when($request->firm_id, function (Builder $query) use ($request) {
                        $query->where('firm_id', $request->firm_id);
                    })
                    ->orderBy('name')
                    ->offset(0)
                    ->limit(50)
                    ->get()
                    ->map(fn (FirmPosition $firmPosition) => [
                        'id' => $firmPosition->id,
                        'value' => $firmPosition->name,
                        'label' => Str::limit($firmPosition->name, 40),
                    ]);

                return response()->json($firmPositions);

            default:
                return response()->json([]);
        }
    }

    private function cyr2latMapper(string $q): string
    {
        $chars = [
            'А' => 'A',
            'Б' => 'B',
            'В' => 'B',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ж' => 'J',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'H',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'P',
            'С' => 'C',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'X',
            'Ц' => 'C',
            'Ч' => 'C',
            'Ш' => 'S',
            'Щ' => 'S',
            'Ъ' => 'Y',
            'Ю' => 'Y',
            'Я' => 'Y',
        ];
        if (0 < strlen($q)) {
            for ($i = 0; $i < strlen($q); $i++) {
                $q = str_replace(array_keys($chars), array_values($chars), $q);
            }
        }

        return $q;
    }
}
