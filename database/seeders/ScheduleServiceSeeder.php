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
        // Recupero os Services
        $service1 = Service::where('id', 1)->first();
        $service2 = Service::where('id', 2)->first();

        //Recupero as Schedules
        $schedule = Schedule::first();
        $schedule2 = Schedule::where('id', 2)->first();
        $schedule3 = Schedule::where('id', 3)->first();

        // Attach Services em Schedule
        $schedule->services()->attach($service1->id);
        $schedule->services()->attach($service2->id);
        $schedule2->services()->attach($service1->id);
        $schedule2->services()->attach($service2->id);
        $schedule3->services()->attach($service2->id);
        $schedule3->services()->attach($service2->id);

    }
}
