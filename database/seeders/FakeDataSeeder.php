<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FamilyDoctor;
use App\Models\Firm;
use App\Models\FirmPosition;
use App\Models\FirmStructure;
use App\Models\FirmSubDivision;
use App\Models\FirmWorkPlace;
use App\Models\User;
use App\Models\Worker;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdminUser();
        $this->createUsers();
//        $this->createFamilyDoctors();
//        $this->createFirms();
    }

    private function createAdminUser(): void
    {
        $adminUser = DB::connection('old')->table('users')
            ->where('user_name', 'admin')
            ->first();

        $dateCreated = null;
        if (! empty($adminUser->date_created)) {
            try {
                $dateCreated = Carbon::parse($adminUser->date_created);
            } catch (Exception $ex) {
                //
            }
        }

        if ($adminUser) {
            DB::table('users')->insert([
                'id' => $adminUser->user_id,
                'first_name' => $adminUser->fname,
                'last_name' => $adminUser->lname,
                'email' => ! empty($adminUser->email) ? $adminUser->email : $adminUser->user_name.'@stm.com',
                'username' => $adminUser->user_name,
                'password' => Hash::make($adminUser->user_pass),
                'ip_address' => ! empty($adminUser->REMOTE_ADDR) ? $adminUser->REMOTE_ADDR : null,
                'last_login_at' => ! empty($adminUser->date_last_login) ? Carbon::parse($adminUser->date_last_login) : null,
                'created_at' => $dateCreated,
                'updated_at' => ! empty($adminUser->date_modified) ? Carbon::parse($adminUser->date_modified) : null,
            ]);

            User::findOrFail($adminUser->user_id)->assignRole('super-admin');
        }
    }

    private function createUsers(): void
    {
        $users = DB::connection('old')->table('users')
            ->where('user_name', '!=', 'admin')
            ->get();
        foreach ($users as $user) {
            $username = $user->user_name;
            if ('nikolova' === Str::lower($user->user_name)) {
                $username .= '_'.$user->user_id;
            }

            DB::table('users')->insert([
                'id' => $user->user_id,
                'first_name' => $user->fname,
                'last_name' => $user->lname,
                'email' => $username.'@stm.com',
                'username' => $username,
                'password' => Hash::make($user->user_pass),
                'ip_address' => ! empty($user->REMOTE_ADDR) ? $user->REMOTE_ADDR : null,
                'last_login_at' => ! empty($user->date_last_login) ? Carbon::parse($user->date_last_login) : null,
                'created_at' => ! empty($user->date_created) ? Carbon::parse($user->date_created) : null,
                'updated_at' => ! empty($user->date_modified) ? Carbon::parse($user->date_modified) : null,
            ]);

            User::findOrFail($user->user_id)->assignRole('office-staff');
        }
    }

    private function createFirms(): void
    {
        Firm::factory(100)->create()->each(function (Firm $firm) {
            $firmSubDivisionIds = [];
            $firmWorkPlaceIds = [];
            $firmPositionIds = [];

            FirmSubDivision::factory(10)->create(['firm_id' => 1])
                ->each(function (FirmSubDivision $firmSubDivision) use (&$firmSubDivisionIds) {
                    $firmSubDivisionIds[] = $firmSubDivision->id;
                });

            FirmWorkPlace::factory(10)->create(['firm_id' => $firm->id])
                ->each(function (FirmWorkPlace $firmWorkPlace) use (&$firmWorkPlaceIds) {
                    $firmWorkPlaceIds[] = $firmWorkPlace->id;
                });

            FirmPosition::factory(10)->create(['firm_id' => $firm->id])
                ->each(function (FirmPosition $firmPosition) use (&$firmPositionIds) {
                    $firmPositionIds[] = $firmPosition->id;
                });

            for ($i = 0; $i < 10; $i++) {
                $firmStructure = FirmStructure::create([
                    'firm_id' => $firm->id,
                    'firm_sub_division_id' => $firmSubDivisionIds[$i],
                    'firm_work_place_id' => $firmWorkPlaceIds[$i],
                    'firm_position_id' => $firmPositionIds[$i],
                ]);
            }

            Worker::factory(random_int(2, 40))->create([
                'firm_id' => $firm->id,
                'firm_structure_id' => $firmStructure->id,
            ]);
        });
    }

    private function createFamilyDoctors(): void
    {
        FamilyDoctor::factory(20)->create();
    }
}
