<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('client')->insert([
            [
                'name' => 'Gabriel Pereira',
                'email' => 'pereiragabrieldev@gmail.com',
                'password' => bcrypt('gabriel'),
                'telephone' => '67981957833',
                'image' => 'teste',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
