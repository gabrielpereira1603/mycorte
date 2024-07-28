<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index($tokenCompany)
    {
        $today = Carbon::today()->format('Y-m-d');

        // Inicializa os dados com dados de exemplo
        return view('Collaborator.dashboardCollaborator', [
            'tokenCompany' => $tokenCompany,
            'dates' => [],
            'counts' => [],
            'startDate' => Carbon::today()->format('d-m-Y'),
            'endDate' => Carbon::today()->format('d-m-Y'),
        ]);
    }
}
