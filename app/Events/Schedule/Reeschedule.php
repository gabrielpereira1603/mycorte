<?php

namespace App\Events\Schedule;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Reeschedule implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $existingSchedule;
    public $schedule;
    public $services;
    public $client;
    public $hoursUntilStart;
    public $minutesUntilStart;

    public function __construct($existingSchedule, $schedule, $services, $client, $hoursUntilStart, $minutesUntilStart)
    {
        $this->existingSchedule = $existingSchedule;
        $this->schedule = $schedule;
        $this->services = $services;
        $this->client = $client;
        $this->hoursUntilStart = $hoursUntilStart;
        $this->minutesUntilStart = $minutesUntilStart;
    }


    public function broadcastOn()
    {
        return new Channel('schedule');
    }

    public function broadcastAs()
    {
        return 'reeschedule';
    }
}
