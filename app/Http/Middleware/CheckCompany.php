<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenCompany = $request->route('tokenCompany');

        $company = Company::where('token', $tokenCompany)->first();

        if (!$company){
            return redirect()->route('allcompany');
        }

        return $next($request, ['company' => $company]);
    }
}
