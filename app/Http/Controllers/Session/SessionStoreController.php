<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionStoreController extends Controller
{
    public function store(Request $request)
    {
        // Limpa dados antigos da sessão
        session()->forget('dynamicData');

        // Armazena novos dados na sessão
        session(['dynamicData' => $request->all()]);

        // Redireciona para a rota desejada
        return redirect()->route($request->input('redirectRoute'),
            ['tokenCompany' => $request->input('tokenCompany'),
            'collaboratorId' => $request->input('collaboratorId')]
        );
    }
}
