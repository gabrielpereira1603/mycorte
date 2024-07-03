<?php

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\LoginClientController;
use App\Http\Controllers\Client\LogoutClientController;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\Client\RedirectIfAuthenticatedClient;
use App\Models\Style;
use Illuminate\Support\Facades\Route;

// Compose data for all views using layoutClient
view()->composer('components.layoutClient', function ($view) {
    // Capturar o tokenCompany da rota atual
    $tokenCompany = request()->route('tokenCompany');

    // Buscar o estilo baseado no tokenCompany
    $style = Style::whereHas('company', function ($query) use ($tokenCompany) {
        $query->where('token', $tokenCompany);
    })->first();

    // Passar o estilo para a view
    $view->with('style', $style);
});

Route::get('/', function () {
    return view('allcompany');
});

Route::get('/loginclient/{tokenCompany}', [
    LoginClientController::class, 'index'])
    ->name('loginclient')
    ->middleware(CheckCompany::class)
    ->middleware(RedirectIfAuthenticatedClient::class);

Route::post('/loginclient/{tokenCompany}', [LoginClientController::class, 'login'])->name('loginclient.post');
Route::post('/logoutclient/{tokenCompany}', [LogoutClientController::class, 'logout'])->name('logoutclient');

Route::get('/homeclient/{tokenCompany}', [
    HomeClientController::class, 'index'])
    ->name('homeclient')
    ->middleware(CheckCompany::class);
