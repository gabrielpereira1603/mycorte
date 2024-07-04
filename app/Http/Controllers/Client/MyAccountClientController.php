<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAccountClientController extends Controller
{
    public function index($tokenCompany){
        return view('Client.myaccountClient',[
        'tokenCompany' => $tokenCompany
        ]);
    }
}
