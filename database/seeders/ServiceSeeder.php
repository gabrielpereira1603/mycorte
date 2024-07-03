<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service')->insert([
            [
                'name' => 'Corte de Cabelo Masculino',
                'time' => '00:30:00',
                'value' => 35.00,
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coloração de Cabelo',
                'time' => '01:00:00',
                'value' => 120.00,
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Corte de Cabelo Masculino',
                'time' => '00:30:00',
                'value' => 35.00,
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coloração de Cabelo',
                'time' => '01:00:00',
                'value' => 120.00,
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
