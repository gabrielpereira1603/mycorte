<?php

use App\Http\Controllers\Client\LoginClientController;
use App\Http\Middleware\CheckCompany;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Ae Jão esse ->name() e como a gente chama essa rota de login dentro do projeto
//Entao se vc for chama essa rota no arquivo blade voce usa o metodo correto lá de chamar
//Passando o valor que está dentro de name
Route::get('/loginclient/{tokenCompany}', [
    LoginClientController::class, 'index'])
    ->name('loginclient')
    ->middleware(CheckCompany::class);

Route::post('/loginclient', [LoginClientController::class, 'login'])->name('loginclient.post');
