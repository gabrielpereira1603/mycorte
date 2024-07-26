<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AllCompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['style', 'promotions'])->get();
        return view('allcompany', ['companies' => $companies]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $companies = Company::with(['style', 'promotions'])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('city', 'LIKE', "%{$query}%")
            ->orWhere('neighborhood', 'LIKE', "%{$query}%")
            ->orWhere('state', 'LIKE', "%{$query}%")
            ->orWhere('number', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($companies);
    }

}
