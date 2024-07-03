<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ClientSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(StyleSeeder::class);
        $this->call(CollaboratorSeeder::class);
        $this->call(ServiceSeeder::class);
    }
}
