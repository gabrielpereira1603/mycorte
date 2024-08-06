<?php

use App\Http\Controllers\Api\AvailabilityCollaboratorApiController;
use App\Http\Controllers\Api\Dashboard\DashboardCollaboratorApiController;
use App\Http\Controllers\Api\IntervalCollaboratorApiController;
use App\Http\Controllers\Api\ReminderScheduleClientApiController;
use App\Http\Controllers\Api\Report\TotalScheduleApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\Collaborator\DashboardController;
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

Route::post('/send-reminder/{scheduleId}', [ReminderScheduleClientApiController::class, 'sendReminder']);

Route::prefix('dashboard')->group(function () {
    Route::get('/getData/bestServices/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchBestServicesData']);
    Route::get('/getData/scheduleAnalysis/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchScheduleAnalysisData']);
    Route::get('/getData/revenueAnalysis/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchRevenueAnalysisData']);
    Route::get('/getData/canceledAppointments/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchCanceledAppointmentsData']);
    Route::get('/getData/rescheduledAppointments/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchRescheduledAppointmentsData']);
    Route::get('/getData/timeAnalysis/{startDate}/{endDate}/{collaboratorId}', [DashboardCollaboratorApiController::class, 'fetchTimeAnalysisData']);
});

Route::get('/totalschedule/{collaboratorId}/{start}/{end}', [TotalScheduleApiController::class, 'getTotalSchedule'])->name('api-total-schedule');
