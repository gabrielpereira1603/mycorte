<?php

namespace App\Events\Schedule;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduleCreate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $schedule;
    public $services;
    public $client;
    public $hoursUntilStart;
    public $minutesUntilStart;

    public function __construct($schedule, $services, $client, $hoursUntilStart, $minutesUntilStart)
    {
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
        return 'create-schedule';
    }
}
