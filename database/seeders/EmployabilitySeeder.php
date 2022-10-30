<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MkbCode;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployabilitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employabilities')->delete();

        $employabilities = DB::connection('old')
            ->table('readjustments')
            ->orderBy('worker_id')
            ->orderBy('id')
            ->get();

        $oldWorkerId = null;
        $position = 1;
        $mkbCodeIds = [];

        foreach ($employabilities as $employability) {
            try {
                if ($oldWorkerId !== $employability->worker_id) {
                    $oldWorkerId = $employability->worker_id;
                    $position = 1;
                }

                if (!isset($mkbCodeIds[$employability->mkb_id])) {
                    if ($mkbCode = MkbCode::where('code', $employability->mkb_id)->first()) {
                        $mkbCodeIds[$employability->mkb_id] = $mkbCode->id;
                    }
                }

                DB::table('employabilities')->insert([
                    'id' => $employability->id,
                    'worker_id' => $employability->worker_id,
                    'published_at' => !empty($employability->published_on) ? Carbon::parse($employability->published_on) : null,
                    'mkb_code_id' => $mkbCodeIds[$employability->mkb_id] ?? null,
                    'diagnosis' => $employability->diagnosis,
                    'authorities' => $employability->commission,
                    'start_date' => !empty($employability->start_date) ? Carbon::parse($employability->start_date) : null,
                    'end_date' => !empty($employability->end_date) ? Carbon::parse($employability->end_date) : null,
                    'employability_place' => !empty($employability->place) ? $employability->place : null,
                    'position' => $position++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            } catch (Exception $ex) {
                // $this->command->error($ex->getMessage());
            }
        }
    }
}
