<?php

namespace App\Http\Middleware\Collaborator;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCollaborator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('collaborator')->check()) {
            Session::flash('error', 'Você precisa estar logado para acessar esta página.');
            return redirect()->route('logincollaborator', ['tokenCompany' => $request->tokenCompany]);
        }

        $collaborator = Auth::guard('collaborator')->user();
        View::share('collaborator', $collaborator);
        View::share('collaboratorRole', $collaborator->role);

        return $next($request);
    }
}
