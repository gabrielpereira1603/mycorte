<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntervalCollaboratorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('interval_collaborator')->insert([
            [
                'reason' => 'Almoço',
                'hourStart' => '12:00:00',
                'hourFinal' => '13:30:00',
                'date' => '2024-07-04',
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
