<?php

namespace App\Http\Controllers\Collaborator\Modules\Configuration;

use App\Http\Controllers\Controller;

class ConfigCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.Modules.Config.index', [
            'tokenCompany' => $tokenCompany
        ]);
    }
}
