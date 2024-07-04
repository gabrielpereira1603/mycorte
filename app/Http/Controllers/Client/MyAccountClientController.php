<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAccountClientController extends Controller
{
    public function index($tokenCompany){
        $client = session('client'); // Recuperar dados do cliente da sessão

        return view('Client.myaccountClient',[
        'tokenCompany' => $tokenCompany],
        compact('client'));
    }


}
