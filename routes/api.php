<?php

use App\Http\Controllers\Api\AvailabilityCollaboratorApiController;
use App\Http\Controllers\Api\IntervalCollaboratorApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use Illuminate\Support\Facades\Route;

Route::get('/schedule/data/{date}/{companyId}/{collaboratorId}',
    [ScheduleApiController::class, 'getScheduleData']
);

Route::get('/availabilityCollaborator/collaborator/{collaboratorId}',
    [AvailabilityCollaboratorApiController::class, 'getAvailabilityCollaborators']
);

Route::get('/intervalCollaborator/collaborator/{collaboratorId}',
    [IntervalCollaboratorApiController::class, 'getIntervalCollaborators']
);
