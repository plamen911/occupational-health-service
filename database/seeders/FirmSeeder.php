<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirmSeeder extends Seeder
{
    public function run(): void
    {
        $firms = DB::connection('old')
            ->table('firms')
            ->where('is_active', '1')
            ->get();

        $userIds = User::pluck('id')->toArray();

        foreach ($firms as $firm) {
            DB::table('firms')->insert([
                'id' => $firm->firm_id,
                'name' => cleanText($firm->name),
                'manager' => cleanText($firm->FirmUpravitel),
                'address' => cleanText($firm->address),
                'email' => ! empty($firm->email) ? $firm->email : null,
                'phone1' => ! empty($firm->phone1) ? $firm->phone1 : null,
                'phone2' => ! empty($firm->phone2) ? $firm->phone2 : null,
                'notes' => ! empty($firm->notes) ? cleanText($firm->notes) : null,
                'created_at' => Carbon::parse($firm->date_added),
                'updated_at' => Carbon::parse($firm->date_modified),
                'created_by' => in_array($firm->added_by, $userIds) ? $firm->added_by : null,
                'updated_by' => in_array($firm->modified_by, $userIds) ? $firm->modified_by : null,
            ]);
        }
    }
}
