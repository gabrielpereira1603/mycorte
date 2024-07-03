<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginClientController extends Controller
{
    }

    public function login(Request $request): RedirectResponse
    {
        // Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tentar autenticar como Client
        $client = Client::where('email', $request->email)->first();

        if ($client && password_verify($request->password, $client->password)) {
            Auth::guard('client')->login($client);

        }

        // Autenticação falhou
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ])->onlyInput('email');
    }
}
