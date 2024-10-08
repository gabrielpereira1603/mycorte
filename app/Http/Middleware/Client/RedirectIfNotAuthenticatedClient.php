<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticatedClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('client')->check()) {
            Session::flash('error', 'Você precisa estar logado para acessar esta página.');
            return redirect()->route('loginclient', ['tokenCompany' => $request->tokenCompany]);
        }

        return $next($request);
    }
}
