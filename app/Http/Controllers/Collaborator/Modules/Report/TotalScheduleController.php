<?php

namespace App\Http\Controllers\Collaborator\Modules\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TotalScheduleController extends Controller
{
    public function index($tokenCompany){
        return view('Collaborator.Modules.Report.indexTotalSchedule',[
            'tokenCompany' => $tokenCompany
        ]);
    }

    public function totalScheduleReport(Request $request, $tokenCompany)
    {

    }
}
