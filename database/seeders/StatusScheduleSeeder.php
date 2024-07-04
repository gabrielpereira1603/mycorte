<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_schedule')->insert([
            [
                'status' => 'Agendado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Reagendado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Cancelado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Finalizado',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
