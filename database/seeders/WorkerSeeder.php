<?php

namespace Database\Seeders;

use App\Models\FamilyDoctor;
use App\Models\Firm;
use App\Models\FirmStructure;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{
    public function run(): void
    {
        $workers = DB::connection('old')
            ->table('workers')
            ->where('is_active', 1)
            ->get();

        $userIds = User::pluck('id')->toArray();
        $firmIds = Firm::pluck('id')->toArray();
        $firmStructureIds = FirmStructure::pluck('id')->toArray();
        $familyDoctorIds = FamilyDoctor::pluck('id')->toArray();

        $this->command->getOutput()->progressStart($workers->count());

        foreach ($workers as $worker) {
            if (! in_array($worker->firm_id, $firmIds)) {
                continue;
            }

            try {
                DB::table('workers')->insert([
                    'id' => $worker->worker_id,
                    'firm_id' => $worker->firm_id,
                    'first_name' => cleanText($worker->fname),
                    'second_name' => cleanText($worker->sname),
                    'last_name' => cleanText($worker->lname),
                    'gender' => 'Ж' === $worker->sex ? 'f' : 'm',
                    'id_number' => $worker->egn,
                    'birth_date' => ! empty($worker->birth_date) ? Carbon::parse($worker->birth_date) : null,
                    'address' => ! empty($worker->address) ? cleanText($worker->address) : null,
                    'email' => ! empty($worker->email) ? $worker->email : null,
                    'phone1' => ! empty($worker->phone1) ? $worker->phone1 : null,
                    'phone2' => ! empty($worker->phone2) ? $worker->phone2 : null,
                    'firm_structure_id' => in_array((int) $worker->map_id, $firmStructureIds) ? $worker->map_id : null,
                    'family_doctor_id' => in_array($worker->doctor_id, $familyDoctorIds) ? $worker->doctor_id : null,
                    'job_start_at' => ! empty($worker->date_curr_position_start) ? Carbon::parse($worker->date_curr_position_start) : null,
                    'career_start_at' => ! empty($worker->date_career_start) ? Carbon::parse($worker->date_career_start) : null,
                    'retired_at' => ! empty($worker->date_retired) ? Carbon::parse($worker->date_retired) : null,
                    'notes' => $worker->notes,
                    'created_at' => ! empty($worker->date_added) ? Carbon::parse($worker->date_added) : null,
                    'updated_at' => ! empty($worker->date_modified) ? Carbon::parse($worker->date_modified) : null,
                    'created_by' => in_array($worker->modified_by, $userIds) ? $worker->modified_by : null,
                    'updated_by' => in_array($worker->modified_by, $userIds) ? $worker->modified_by : null,
                ]);
            } catch (Exception $ex) {
                $this->command->error($ex->getMessage());
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
