<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleClientController extends Controller
{
    public function index($tokenCompany, $collaboratorId)
    {
        return view('Client.scheduleClient',[
                'tokenCompany' => $tokenCompany,
                'collaboratorId' => $collaboratorId
            ]
        );
    }
}
