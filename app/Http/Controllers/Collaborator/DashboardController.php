<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.dashboardCollaborator', ['tokenCompany' => $tokenCompany]);
    }

}
