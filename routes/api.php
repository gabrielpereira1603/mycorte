<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota para buscar dados de agendamento por data, id da empresa e id do colaborador
Route::get('/schedule/data/{date}/{companyId}/{collaboratorId}', function (Request $request, $date, $companyId, $collaboratorId) {
    // Aqui você implementa a lógica para buscar os dados de agendamento
})->middleware('auth:sanctum');

// Rota para buscar disponibilidade do colaborador por id do colaborador
Route::get('/availabilityCollaborator/collaborator/{collaboratorId}', function (Request $request, $collaboratorId) {
    // Aqui você implementa a lógica para buscar a disponibilidade do colaborador
})->middleware('auth:sanctum');

// Rota para buscar intervalos do colaborador por id do colaborador
Route::get('/intervalCollaborator/collaborator/{collaboratorId}', function (Request $request, $collaboratorId) {
    // Aqui você implementa a lógica para buscar os intervalos do colaborador
})->middleware('auth:sanctum');
