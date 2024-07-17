<?php

namespace App\Events;

use Faker\Provider\Base;
use Pusher\Pusher as BasePusher;
use Exception;
use Illuminate\Support\Facades\Log;

class Pusher
{
    private string $auth_key;
    private string $secret_key;
    private string $app_id;
    private array $options;

    public function __construct(
        $auth_key = '5d7bf54f12d3762e40fb',
        $secret_key = 'dc2e4716cd08ffa63d7e',
        $app_id = '1835130',
        $options = array(
            'cluster' => 'sa1',
            'useTLS' => true
        )
    )
    {
        $this->auth_key = $auth_key;
        $this->secret_key = $secret_key;
        $this->app_id = $app_id;
        $this->options = $options;
    }

    public function trigger($channel, $event, $data = null)
    {
        try {
            $pusher = new BasePusher(
                $this->auth_key,
                $this->secret_key,
                $this->app_id,
                $this->options
            );

            $pusher->trigger($channel, $event, $data);
        } catch (Exception $e) {
            Log::error('Pusher error: ' . $e->getMessage());
        }
    }
}
