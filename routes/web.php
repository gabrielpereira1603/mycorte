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

// Agrupamento de rotas para o cliente com prefixo e middleware comuns
Route::prefix('/client')->middleware([CheckCompany::class])->group(function () {

    // Rota de login do cliente
    Route::get('/login/{tokenCompany}', [LoginClientController::class, 'index'])
        ->name('loginclient');

    Route::post('/login/{tokenCompany}', [LoginClientController::class, 'login'])
        ->name('loginclient.post')
        ->middleware(RedirectIfAuthenticatedClient::class);

    // Rota de logout do cliente
    Route::post('/logout/{tokenCompany}', [LogoutClientController::class, 'logout'])
        ->name('logoutclient');

    // Rota da página inicial do cliente
    Route::get('/home/{tokenCompany}', [HomeClientController::class, 'index'])
        ->name('homeclient');
});

// Rota padrão para página inicial de todas as empresas
Route::get('/', function () {
    return view('allcompany');
});
