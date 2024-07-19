<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {

        return view('Collaborator.configcollaborator', [
            'tokenCompany' => $tokenCompany
        ]);
    }
}
