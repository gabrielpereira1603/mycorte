<?php

use App\Http\Controllers\AllCompanyController;
use App\Http\Controllers\Client\CaptureEmailController;
use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\LoginClientController;
use App\Http\Controllers\Client\LogoutClientController;
use App\Http\Controllers\Client\MyAccountClientController;
use App\Http\Controllers\Client\MyCuts\CancelScheduleController;
use App\Http\Controllers\Client\MyCuts\MyCutsClientController;
use App\Http\Controllers\Client\MyCuts\MyHistoricCutsClientController;
use App\Http\Controllers\Client\MyCuts\RescheduleClientController;
use App\Http\Controllers\Client\ScheduleClientController;
use App\Http\Controllers\Client\ServiceBySchedule\InsertServiceByScheduleController;
use App\Http\Controllers\Client\ServiceBySchedule\ServiceByScheduleController;
use App\Http\Controllers\Client\SingupClientController;
use App\Http\Controllers\Client\UploadPhotoClientController;
use App\Http\Controllers\Collaborator\ConfigCollaboratorController;
use App\Http\Controllers\Collaborator\HomeCollaboratorController;
use App\Http\Controllers\Collaborator\Login\ForgotPasswordCollaboratorController;
use App\Http\Controllers\Collaborator\Login\LoginCollaboratorController;
use App\Http\Controllers\Collaborator\Login\LogoutCollaboratorController;
use App\Http\Controllers\Collaborator\ServicesCollaboratorController;
use App\Http\Controllers\Session\SessionStoreController;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\Client\RedirectIfAuthenticatedClient;
use App\Http\Middleware\Client\RedirectIfNotAuthenticatedClient;
use App\Http\Middleware\Collaborator\AuthenticateCollaborator;
use App\Http\Middleware\Collaborator\ResetPasswordCollaborator;
use App\Models\Style;
use Illuminate\Support\Facades\Route;

// Compose data for all views using layoutClient
view()->composer('components.layoutClient', function ($view) {
    $tokenCompany = request()->route('tokenCompany');
    $style = Style::whereHas('company', function ($query) use ($tokenCompany) {
        $query->where('token', $tokenCompany);
    })->first();
    $view->with('style', $style);
});

// Agrupamento de rotas para o cliente com prefixo e middleware comuns
Route::prefix('/client')->middleware([CheckCompany::class])->group(function () {
    Route::middleware([RedirectIfAuthenticatedClient::class])->group(function () {
        Route::get('/login/{tokenCompany}', [LoginClientController::class, 'index'])->name('loginclient');
        Route::post('/login/{tokenCompany}', [LoginClientController::class, 'login'])->name('loginclient.post');
        Route::get('/singup/{tokenCompany}', [SingupClientController::class, 'index'])->name('singupclient');
    });

    Route::post('/singup/{tokenCompany}', [SingupClientController::class, 'register'])->name('singupclient.post');
    Route::post('/cancel-schedule/{tokenCompany}/{scheduleId}', [CancelScheduleController::class, 'cancel'])->name('cancel.schedule');
    Route::post('/logout/{tokenCompany}', [LogoutClientController::class, 'logout'])->name('logoutclient');
    Route::get('/home/{tokenCompany}', [HomeClientController::class, 'index'])->name('homeclient');

    Route::middleware([RedirectIfNotAuthenticatedClient::class])->group(function () {
        Route::get('/myaccount/{tokenCompany}', [MyAccountClientController::class, 'index'])->name('myaccountclient');
        Route::post('myaccount/{tokenCompany}/update', [MyAccountClientController::class, 'update'])->name('client.myaccount.update');
        Route::post('/uploadPhotoClient/{tokenCompany}', [UploadPhotoClientController::class, 'uploadPhoto'])->name('uploadPhotoClient');
        Route::get('/mycuts/{tokenCompany}', [MyCutsClientController::class, 'index'])->name('mycutsclient');
        Route::get('/historico-agendamentos/{tokenCompany}', [MyHistoricCutsClientController::class, 'index'])->name('myhistoriccuts');
    });

    Route::get('/search/schedules', [MyHistoricCutsClientController::class, 'search'])->name('search.schedules');
    Route::get('/all-schedules/{tokenCompany}', [MyHistoricCutsClientController::class, 'getAllSchedules'])->name('all.schedules');
    Route::post('/reschedule/{tokenCompany}', [RescheduleClientController::class, 'reschedule'])->name('rescheduleclient');
    Route::get('/schedule/{tokenCompany}/{collaboratorId}', [ScheduleClientController::class, 'index'])->name('scheduleclient');
    Route::get('/service/{tokenCompany}/{collaboratorId}', [ServiceByScheduleController::class, 'index'])->name('serviceBySchedule');
    Route::post('/service/{tokenCompany}', [InsertServiceByScheduleController::class, 'createSchedule'])->name('insertServiceBySchedule');
});

Route::post('/store-session-data', [SessionStoreController::class, 'store'])->name('dataTransporter');
Route::get('/', [AllCompanyController::class, 'index'])->name('allCompany');
Route::get('/search-companies', [AllCompanyController::class, 'search'])->name('search.companies');
Route::get('/sobre', fn() => view('about'))->name('aboutFooter');
Route::get('/termos-de-uso', fn() => view('termsOfUse'))->name('terms-of-use');
Route::get('/politica-de-privacidade', fn() => view('privacypolicy'))->name('privacy-policy');
Route::post('/capture-email/{tokenCompany}', [CaptureEmailController::class, 'send'])->name('capture.email');

// Agrupamento de rotas para o colaborador com prefixo e middleware comuns
Route::prefix('/collaborator')->middleware([CheckCompany::class])->group(function () {
    Route::get('/login/{tokenCompany}', [LoginCollaboratorController::class, 'index'])->name('logincollaborator');
    Route::post('/login/{tokenCompany}', [LoginCollaboratorController::class, 'login'])->name('logincollaborator.post');
    Route::post('/logout/{tokenCompany}', [LogoutCollaboratorController::class, 'logout'])->name('logoutcollaborator');
    Route::post('/forgotpassword/{tokenCompany}', [ForgotPasswordCollaboratorController::class, 'resetPasswordEmail'])->name('forgotPasswordCollaborator');

    Route::middleware([ResetPasswordCollaborator::class])->group(function () {
        Route::get('/viewforgotpassword/{tokenCompany}', [ForgotPasswordCollaboratorController::class, 'indexTokenForgotPassword'])->name('viewValidateToken');
        Route::post('/validateToken/{tokenCompany}', [ForgotPasswordCollaboratorController::class, 'validateToken'])->name('validateTokenForgotPasswordCollaborator');
        Route::get('/resetpassword/{tokenCompany}', [ForgotPasswordCollaboratorController::class, 'resetPasswordIndex'])->name('resetPasswordCollaboratorView');
        Route::post('/resetpassword/{tokenCompany}', [ForgotPasswordCollaboratorController::class, 'resetPassword'])->name('resetPasswordCollaborator.post');
    });

    Route::middleware([AuthenticateCollaborator::class])->group(function () {
        Route::get('/home/{tokenCompany}', [HomeCollaboratorController::class, 'index'])->name('homecollaborator');
        Route::get('/services/{tokenCompany}', [ServicesCollaboratorController::class, 'services'])->name('servicescollaborator');
        Route::get('/config/{tokenCompany}', [ConfigCollaboratorController::class, 'index'])->name('configcollaborator');
    });
});

