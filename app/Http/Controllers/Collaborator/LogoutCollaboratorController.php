<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutCollaboratorController extends Controller
{
    public function logout(Request $request, $tokenCompany)
    {
        Auth::guard('collaborator')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany]);
    }
}
