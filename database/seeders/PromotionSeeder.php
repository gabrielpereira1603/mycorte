<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promotion')->insert([
            [
                'name' => 'Promoção de Verão',
                'dataHourStart' => '2024-07-01 00:00:00',
                'dataHourFinal' => '2024-07-31 23:59:59',
                'value' => 50.00,
                'servicefk' => 1,
                'companyfk' => 1,
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promoção de Inverno',
                'dataHourStart' => '2024-12-01 00:00:00',
                'dataHourFinal' => '2024-12-31 23:59:59',
                'value' => 60.00,
                'servicefk' => 2,
                'companyfk' => 1,
                'collaboratorfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promoção de Primavera',
                'dataHourStart' => '2024-04-01 00:00:00',
                'dataHourFinal' => '2024-04-30 23:59:59',
                'value' => 40.00,
                'servicefk' => 3,
                'companyfk' => 1,
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promoção de Outono',
                'dataHourStart' => '2024-10-01 00:00:00',
                'dataHourFinal' => '2024-10-31 23:59:59',
                'value' => 55.00,
                'servicefk' => 4,
                'companyfk' => 1,
                'collaboratorfk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
