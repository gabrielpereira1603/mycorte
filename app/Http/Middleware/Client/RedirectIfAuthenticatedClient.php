<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'client')
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->route('homeclient', ['tokenCompany' => $request->tokenCompany]);
        }

        return $next($request);
    }
}
