<?php

use App\Http\Controllers\Api\ScheduleApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/schedule/data/{date}/{companyId}/{collaboratorId}',
    [ScheduleApiController::class, 'getScheduleData']
);

