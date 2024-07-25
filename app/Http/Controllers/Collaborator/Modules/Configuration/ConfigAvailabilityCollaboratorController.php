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

    public function createAvailability(Request $request, $tokenCompany)
    {
        $validatedData = $request->validate([
            'startWork' => 'required|date_format:H:i',
            'endWork' => 'required|date_format:H:i',
            'startLunch' => 'required|date_format:H:i',
            'endLunch' => 'required|date_format:H:i',
            'serviceInterval' => 'required|date_format:H:i',
            'workDays' => 'required|in:Segunda,Terca,Quarta,Quinta,Sexta,Sabado,Domingo',
            'collaboratorfk' => 'required|exists:collaborator,id',
        ]);

        $availability = AvailabilityCollaborator::updateOrCreate(
            ['id' => $request->input('availabilityId')],
            [
                'hourStart' => $validatedData['startWork'],
                'hourFinal' => $validatedData['endWork'],
                'lunchTimeStart' => $validatedData['startLunch'],
                'lunchTimeFinal' => $validatedData['endLunch'],
                'hourServiceInterval' => $validatedData['serviceInterval'],
                'workDays' => $validatedData['workDays'],
                'collaboratorfk' => $validatedData['collaboratorfk'],
            ]
        );

        return redirect()->back()->with('success', 'Disponibilidade salva com sucesso!');
    }

}
