<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Get the schedule and services
        $schedule = Schedule::first();
        $service1 = Service::where('id', 1)->first();
        $service2 = Service::where('id', 2)->first();

        // Attach services to schedule
        $schedule->services()->attach($service1->id);
        $schedule->services()->attach($service2->id);
    }
}
