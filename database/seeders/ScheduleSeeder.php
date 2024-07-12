<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schedule')->insert([
            [
                'date' => now(),
                'hourStart' => '09:00:00',
                'hourFinal' => '10:00:00',
                'clientfk' => 1,
                'collaboratorfk' => 1,
                'statusSchedulefk' => 1,
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2024-09-01',
                'hourStart' => '09:00:00',
                'hourFinal' => '10:00:00',
                'clientfk' => 1,
                'collaboratorfk' => 1,
                'statusSchedulefk' => 1,
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => now(),
                'hourStart' => '01:30:00',
                'hourFinal' => '01:50:00',
                'clientfk' => 2,
                'collaboratorfk' => 1,
                'statusSchedulefk' => 1,
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2024-09-01',
                'hourStart' => '11:00:00',
                'hourFinal' => '12:00:00',
                'clientfk' => 2,
                'collaboratorfk' => 1,
                'statusSchedulefk' => 1,
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
