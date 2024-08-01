<?php

namespace App\Http\Controllers\Collaborator\Modules\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.Modules.Report.index', [
            'tokenCompany' => $tokenCompany,
        ]);
    }
}
