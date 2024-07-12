<?php

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\LoginClientController;
use App\Http\Controllers\Client\LogoutClientController;
use App\Http\Controllers\Client\MyAccountClientController;
use App\Http\Controllers\Client\MyCuts\CancelScheduleController;
use App\Http\Controllers\Client\MyCuts\MyCutsClientController;
use App\Http\Controllers\Client\MyCuts\RescheduleClientController;
use App\Http\Controllers\Client\ScheduleClientController;
use App\Http\Controllers\Client\ServiceBySchedule\InsertServiceByScheduleController;
use App\Http\Controllers\Client\ServiceBySchedule\ServiceByScheduleController;
use App\Http\Controllers\Client\SingupClientController;
use App\Http\Controllers\Client\UploadPhotoClientController;
use App\Http\Controllers\Session\SessionStoreController;
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

    // Passar o estilo para a view
    $view->with('style', $style);
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

    // Rota cancel schedule
    Route::post('/cancel-schedule/{tokenCompany}/{scheduleId}', [CancelScheduleController::class, 'cancel'])
        ->name('cancel.schedule');

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

    //Rota de alteração de dados do Cliente
    Route::post('myaccount/{tokenCompany}/update', [MyAccountClientController::class, 'update'])
        ->name('client.myaccount.update');

    // Rota da upload de foto do cliente
    Route::post('/uploadPhotoClient/{tokenCompany}', [UploadPhotoClientController::class, 'uploadPhoto'])
        ->name('uploadPhotoClient')
        ->middleware(RedirectIfNotAuthenticatedClient::class);

    // Rota da mycuts do cliente
    Route::get('/mycuts/{tokenCompany}', [MyCutsClientController::class, 'index'])
        ->name('mycutsclient')
        ->middleware(RedirectIfNotAuthenticatedClient::class);

    // Rota de reagendamento do client
    Route::post('/reschedule/{tokenCompany}', [RescheduleClientController::class, 'reschedule'])
        ->name('rescheduleclient');

    // Rota de horarios de agendamento do client
    Route::get('/schedule/{tokenCompany}/{collaboratorId}', [ScheduleClientController::class, 'index'])
        ->name('scheduleclient');

    // Rota de servicos do agendamento do client
    Route::get('/service/{tokenCompany}/{collaboratorId}', [ServiceByScheduleController::class, 'index'])
        ->name('serviceBySchedule');

    // Rota de cadastro de agendamento do client
    Route::post('/service/{tokenCompany}', [InsertServiceByScheduleController::class, 'createSchedule'])
        ->name('insertServiceBySchedule');
});

Route::post('/store-session-data', [SessionStoreController::class, 'store'])->name('dataTransporter');

// Rota padrão para página inicial de todas as empresas
Route::get('/', function () {
    return view('allcompany');
});
