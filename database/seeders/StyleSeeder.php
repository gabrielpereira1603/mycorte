<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StyleSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('style')->insert([
            [
                'colorText' => '#f8fafc',
                'logo' => 'teste',
                'name' => 'Padrão MyCorte',
                'primaryColor' => '#3A4976',
                'secondaryColor' => '#fca5a5',
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
