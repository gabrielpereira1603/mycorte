<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountClientController extends Controller
{
    public function index($tokenCompany){
        $client = Auth::guard('client')->user();

        return view('Client.myaccountClient', [
            'tokenCompany' => $tokenCompany,
            'client' => $client,
        ]);
    }


}
