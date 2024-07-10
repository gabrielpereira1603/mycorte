<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilityCollaboratorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('availability_collaborator')->insert([
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Segunda',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Terca',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Quarta',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Quinta',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Sexta',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Sabado',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Segunda',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Terca',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Quarta',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Quinta',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Sexta',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'lunchTimeStart' => '11:00:00',
                'lunchTimeFinal' => '12:00:00',
                'hourServiceInterval' => '01:00:00',
                'workDays' => 'Sabado',
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
