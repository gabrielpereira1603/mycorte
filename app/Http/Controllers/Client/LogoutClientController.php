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
        try {
            Auth::guard('client')->logout();

            // Invalidate the session and regenerate the CSRF token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirecionar para a URL de origem ou para a rota de login
            $redirectTo = $request->headers->get('referer') ?: route('loginclient', ['tokenCompany' => $request->tokenCompany]);
            return redirect()->to($redirectTo)->with('success', 'Logout realizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao fazer logout. Por favor, tente novamente.']);
        }
    }
}
