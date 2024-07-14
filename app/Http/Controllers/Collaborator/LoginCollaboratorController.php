<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.Login.loginCollaborator',[
            'tokenCompany' => $tokenCompany
        ]);
    }

    public function login(Request $request, $tokenCompany){
        // Validação
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('password');

        // Verifica se o identificador é um e-mail ou telefone
        $user = Collaborator::where('email', $request->identifier)
            ->orWhere('telephone', $request->identifier)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Autentica o usuário
            Auth::guard('collaborator')->login($user);
            return redirect()->route('homecollaborator', ['tokenCompany' => $tokenCompany]);
        }

        return redirect()->back()->withErrors(['identifier' => 'As credenciais fornecidas estão incorretas.']);
    }
}
