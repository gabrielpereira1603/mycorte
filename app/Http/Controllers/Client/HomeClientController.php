<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeClientController extends Controller
{
    public function index($tokenCompany): View|Factory|Application
    {
        return view('Client.homeClient', ['tokenCompany' => $tokenCompany]);
    }
}
