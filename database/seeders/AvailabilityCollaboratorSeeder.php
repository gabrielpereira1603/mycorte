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
                'hourServiceInterval' => '12:00:00',
                'hourInterval' => '15:00:00',
                'workDays' => 'Segunda',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hourStart' => '08:00:00',
                'hourFinal' => '17:00:00',
                'hourServiceInterval' => '12:00:00',
                'hourInterval' => '15:00:00',
                'workDays' => 'Terça',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
