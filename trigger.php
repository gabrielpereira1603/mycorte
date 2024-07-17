<?php

require 'vendor/autoload.php';

use Pusher\Pusher;

$options = array(
    'cluster' => 'sa1',
    'useTLS' => true
);

$pusher = new Pusher(
    '5d7bf54f12d3762e40fb',
    'dc2e4716cd08ffa63d7e',
    '1835130',
    $options
);

$data = ['message' => 'hello world'];
$pusher->trigger('my-channel', 'my-events', $data);
