<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.dashboardCollaborator', ['tokenCompany' => $tokenCompany]);
    }
}
