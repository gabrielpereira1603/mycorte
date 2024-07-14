<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;

class HomeCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.homecollaborator', ['tokenCompany' => $tokenCompany]);
    }
}
