<?php

namespace Database\Seeders;

use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlurSensitiveDatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Worker::all() as $worker) {
            $gender = 'm' === $worker->gender ? 'male' : 'female';

            $worker->first_name = fake('bg_BG')->firstName($gender);
            $worker->id_number = substr(fake()->creditCardNumber, 0, 10);
            $worker->save();
        }
    }
}
