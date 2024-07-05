<?php

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\LoginClientController;
use App\Http\Controllers\Client\LogoutClientController;
use App\Http\Controllers\Client\MyAccountClientController;
use App\Http\Controllers\Client\MyCutsClientController;
use App\Http\Controllers\Client\ScheduleClientController;
use App\Http\Controllers\Client\SingupClientController;
use App\Http\Controllers\Client\UploadPhotoClientController;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\Client\RedirectIfAuthenticatedClient;
use App\Http\Middleware\Client\RedirectIfNotAuthenticatedClient;
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

    // Se encontrou o estilo, buscar a company associada a ele
    $company = null;
    if ($style) {
        $company = $style->company()->first();
    }

    // Passar o estilo e a empresa para a view
    $view->with('style', $style);
    $view->with('company', $company);
});

// Agrupamento de rotas para o cliente com prefixo e middleware comuns
Route::prefix('/client')->middleware([CheckCompany::class])->group(function () {

    // Rota de login do cliente
    Route::get('/login/{tokenCompany}', [LoginClientController::class, 'index'])
        ->name('loginclient')
        ->middleware(RedirectIfAuthenticatedClient::class);

    // Rota POST de login do cliente
    Route::post('/login/{tokenCompany}', [LoginClientController::class, 'login'])
        ->name('loginclient.post')
        ->middleware(RedirectIfAuthenticatedClient::class);

    // Rota de singup do cliente
    Route::get('/singup/{tokenCompany}', [SingupClientController::class, 'index'])
        ->name('singupclient')
        ->middleware(RedirectIfAuthenticatedClient::class);

    // Rota de singup POST do client
    Route::post('/singup/{tokenCompany}', [SingupClientController::class, 'register'])
        ->name('singupclient.post');

    // Rota de logout do cliente
    Route::post('/logout/{tokenCompany}', [LogoutClientController::class, 'logout'])
        ->name('logoutclient');

    // Rota da página inicial do cliente
    Route::get('/home/{tokenCompany}', [HomeClientController::class, 'index'])
        ->name('homeclient');

    // Rota da myaccount do cliente
    Route::get('/myaccount/{tokenCompany}', [MyAccountClientController::class, 'index'])
        ->name('myaccountclient')
        ->middleware(RedirectIfNotAuthenticatedClient::class);

    Route::post('/uploadPhotoClient/{tokenCompany}', [UploadPhotoClientController::class, 'uploadPhoto'])
        ->name('uploadPhotoClient')
        ->middleware(RedirectIfNotAuthenticatedClient::class);

    Route::get('/mycuts/{tokenCompany}', [MyCutsClientController::class, 'index'])
        ->name('mycutsclient')
        ->middleware(RedirectIfNotAuthenticatedClient::class);

    Route::get('/schedule/{tokenCompany}/{collaboratorId}', [ScheduleClientController::class, 'index'])
        ->name('scheduleclient');
});

// Rota padrão para página inicial de todas as empresas
Route::get('/', function () {
    return view('allcompany');
});
