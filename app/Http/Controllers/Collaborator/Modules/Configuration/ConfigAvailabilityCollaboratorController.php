<?php

namespace App\Http\Controllers\Collaborator\Modules\Configuration;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityCollaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function updateOrCreateAvailability(Request $request, $tokenCompany)
    {
        $messages = [
            'startWork.required' => 'O campo Início do expediente é obrigatório.',
            'startWork.date_format' => 'O campo Início do expediente deve corresponder ao formato H:i:s.',
            'endWork.required' => 'O campo Fim do expediente é obrigatório.',
            'endWork.date_format' => 'O campo Fim do expediente deve corresponder ao formato H:i:s.',
            'startLunch.required' => 'O campo Início do almoço é obrigatório.',
            'startLunch.date_format' => 'O campo Início do almoço deve corresponder ao formato H:i:s.',
            'endLunch.required' => 'O campo Fim do almoço é obrigatório.',
            'endLunch.date_format' => 'O campo Fim do almoço deve corresponder ao formato H:i:s.',
            'serviceInterval.required' => 'O campo Tempo de intervalo entre cada serviço é obrigatório.',
            'serviceInterval.date_format' => 'O campo Tempo de intervalo entre cada serviço deve corresponder ao formato H:i:s.',
            'workDays.required' => 'O campo Dias de trabalho é obrigatório.',
            'workDays.in' => 'O campo Dias de trabalho deve ser um dos seguintes valores: :values.',
            'collaboratorfk.required' => 'O campo Colaborador é obrigatório.',
            'collaboratorfk.exists' => 'O campo Colaborador selecionado é inválido.',
        ];

        $validator = Validator::make($request->all(), [
            'startWork' => 'required',
            'endWork' => 'required',
            'startLunch' => 'required',
            'endLunch' => 'required',
            'serviceInterval' => 'required',
            'workDays' => 'required|in:Segunda,Terca,Quarta,Quinta,Sexta,Sabado,Domingo',
            'collaboratorfk' => 'required|exists:collaborator,id',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verifica se já existe uma disponibilidade para o mesmo dia de trabalho
        $existingAvailability = AvailabilityCollaborator::where('collaboratorfk', $request->input('collaboratorfk'))
            ->where('workDays', $request->input('workDays'))
            ->where('id', '!=', $request->input('availabilityId')) // Ignora o registro atual sendo editado
            ->exists();

        if ($existingAvailability) {
            return redirect()->back()->withErrors(['workDays' => 'Já existe uma disponibilidade cadastrada para este dia de trabalho.'])->withInput();
        }

        $availability = AvailabilityCollaborator::updateOrCreate(
            ['id' => $request->input('availabilityId')],
            [
                'hourStart' => $request->input('startWork'),
                'hourFinal' => $request->input('endWork'),
                'lunchTimeStart' => $request->input('startLunch'),
                'lunchTimeFinal' => $request->input('endLunch'),
                'hourServiceInterval' => $request->input('serviceInterval'),
                'workDays' => $request->input('workDays'),
                'collaboratorfk' => $request->input('collaboratorfk'),
            ]
        );

        return redirect()->back()->with('success', 'Disponibilidade salva com sucesso!');
    }

    public function destroy($id, $tokenCompany)
    {
        $availability = AvailabilityCollaborator::find($id);

        if ($availability) {
            $availability->delete();
            return redirect()->back()->with('success', 'Disponibilidade excluída com sucesso!');
        }

        return redirect()->back()->withErrors(['error' => 'Disponibilidade não encontrada.']);
    }
}
