<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AllCompanyController extends Controller
{
    public function index()
    {
        $company = Company::with('style')->get();

        return view('allcompany', ['companies' => $company]);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $companies = Company::with('style')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('city', 'LIKE', "%{$query}%")
            ->orWhere('neighborhood', 'LIKE', "%{$query}%")
            ->orWhere('state', 'LIKE', "%{$query}%")
            ->orWhere('number', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($companies);
    }
}
