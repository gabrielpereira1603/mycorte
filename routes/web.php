<?php

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\LoginClientController;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\Client\RedirectIfAuthenticated;
use App\Http\Middleware\Client\RedirectIfNotAuthenticatedClient;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginclient/{tokenCompany}', [
    LoginClientController::class, 'index'])
    ->name('loginclient')
    ->middleware(CheckCompany::class);

Route::post('/loginclient/{tokenCompany}', [LoginClientController::class, 'login'])->name('loginclient.post');


Route::get('/homeclient/{tokenCompany}', [
    HomeClientController::class, 'index'])
    ->name('homeclient')
    ->middleware(CheckCompany::class)
    ->middleware(RedirectIfNotAuthenticatedClient::class);
