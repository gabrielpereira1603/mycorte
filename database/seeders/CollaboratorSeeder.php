<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollaboratorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('collaborator')->insert([
            [
                'email' => 'pereiragabrieldev@gmail.com',
                'enabled' => true,
                'image' => 'https://mycorte.somosdevteam.com/storage/app/public/profile_photos/collaborator/jason.png',
                'name' => 'Jason Statham',
                'password' => bcrypt('gabriel'),
                'role' => 'COLLABORATOR',
                'telephone' => '123456789',
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'joaocaetanodev@gmail.com',
                'enabled' => false,
                'image' => 'https://mycorte.somosdevteam.com/storage/app/public/profile_photos/collaborator/jhon.png',
                'name' => 'Jhon Whick',
                'password' => bcrypt('caetano'),
                'role' => 'COLLABORATOR',
                'telephone' => '987654321',
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
