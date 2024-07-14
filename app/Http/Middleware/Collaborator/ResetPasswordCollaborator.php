<?php

namespace App\Http\Middleware\Collaborator;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordCollaborator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenCompany = $request->route('tokenCompany');

        // Verificar se o token existe na sessão
        if (!Session::has('resetpasswordtoken') || !Session::has('resetpasswordtoken_expiration')) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])->with('error', 'Token inválido ou expirado.');
        }

        // Verificar se a sessão expirou
        if (Carbon::now()->greaterThan(Session::get('resetpasswordtoken_expiration'))) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])->with('error', 'Token expirado.');
        }

        // Verificar se o token na sessão bate com o token no banco de dados
        $collaborator = DB::table('collaborator')->where('resetpasswordtoken', Session::get('resetpasswordtoken'))->first();
        if (!$collaborator) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])->with('error', 'Token inválido.');
        }

        return $next($request);
    }
}
