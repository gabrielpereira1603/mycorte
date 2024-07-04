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
                'image' => 'https://mycorte.somosdevteam.com/storage/app/public/profile_photos/yRZLPTBDW3llPcyyb055kZ0h2vy0u2WcnKvxAnGR.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'João Caetano',
                'email' => 'joaocaetanodev@gmail.com',
                'password' => bcrypt('caetano'),
                'telephone' => '67981203040',
                'image' => 'https://mycorte.somosdevteam.com/storage/app/public/profile_photos/l1vZwZ0L3J2mNvy6clwoFNRCXflWoGyzndJc1vzh.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
