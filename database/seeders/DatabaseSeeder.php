<?php

namespace Database\Seeders;

use App\Models\AvailabilityCollaborator;
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
        $this->call(AvailabilityCollaboratorSeeder::class);
        $this->call(IntervalCollaboratorSeeder::class);
        $this->call(StatusScheduleSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ScheduleServiceSeeder::class);
    }
}
