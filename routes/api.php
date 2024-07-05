<?php

use App\Http\Controllers\Api\ScheduleApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/schedule/data/{date}/{companyId}/{collaboratorId}',
    [ScheduleApiController::class, 'getScheduleData']
);

// Rota para buscar disponibilidade do colaborador por id do colaborador
Route::get('/availabilityCollaborator/collaborator/{collaboratorId}', function (Request $request, $collaboratorId) {
    // Aqui você implementa a lógica para buscar a disponibilidade do colaborador
})->middleware('auth:sanctum');

// Rota para buscar intervalos do colaborador por id do colaborador
Route::get('/intervalCollaborator/collaborator/{collaboratorId}', function (Request $request, $collaboratorId) {
    // Aqui você implementa a lógica para buscar os intervalos do colaborador
})->middleware('auth:sanctum');
