<?php

namespace App\Http\Controllers\Collaborator\Modules\Configuration;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityCollaborator;
use Illuminate\Http\Request;

class ConfigAvailabilityCollaboratorController extends Controller
{
    public function index($tokenCompany){
        $availability = AvailabilityCollaborator::where('collaboratorfk', auth('collaborator')->user()->id)
        ->orderBy('workDays')
        ->paginate(1);

        return view('Collaborator.Modules.Config.configAvailability', [
            'tokenCompany' => $tokenCompany,
            'availability' => $availability
        ]);
    }

}
