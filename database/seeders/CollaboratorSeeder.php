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
                'email' => 'gabriel@gmail.com',
                'enabled' => true,
                'image' => null,
                'name' => 'Jason Statham',
                'password' => bcrypt('gabriel'),
                'role' => 'COLLABORATOR',
                'telephone' => '123456789',
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'joao@gmail.com',
                'enabled' => false,
                'image' => null,
                'name' => 'Jhon Whick',
                'password' => bcrypt('joao'),
                'role' => 'COLLABORATOR',
                'telephone' => '987654321',
                'companyfk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
