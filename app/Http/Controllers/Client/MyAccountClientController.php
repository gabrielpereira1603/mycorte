<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountClientController extends Controller
{
    public function index($tokenCompany){
        // Obter o cliente autenticado usando Auth::guard('client')->user()
        $client = Auth::guard('client')->user();

        return view('Client.myaccountClient', [
            'tokenCompany' => $tokenCompany,
            'client' => $client, // Passar o cliente para a view
        ]);
    }


}
