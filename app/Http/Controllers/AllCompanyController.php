<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AllCompanyController extends Controller
{
    public function index()
    {
        $currentDateTime = Carbon::now();
        $companies = Company::with(['style', 'promotions' => function($query) use ($currentDateTime) {
            $query->where('dataHourStart', '<=', $currentDateTime)
                ->where('dataHourFinal', '>=', $currentDateTime);
        }])->get();

        return view('allcompany', ['companies' => $companies]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $currentDateTime = Carbon::now();
        $companies = Company::with(['style', 'promotions' => function($query) use ($currentDateTime) {
            $query->where('dataHourStart', '<=', $currentDateTime)
                ->where('dataHourFinal', '>=', $currentDateTime);
        }])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('city', 'LIKE', "%{$query}%")
            ->orWhere('neighborhood', 'LIKE', "%{$query}%")
            ->orWhere('state', 'LIKE', "%{$query}%")
            ->orWhere('number', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($companies);
    }

}
