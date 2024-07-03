<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutClientController extends Controller
{
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirecionar para a página inicial ou página de login
        return redirect()->route('loginclient', ['tokenCompany' => $request->tokenCompany])->with('success', 'Logout realizado com sucesso!');
    }
}
