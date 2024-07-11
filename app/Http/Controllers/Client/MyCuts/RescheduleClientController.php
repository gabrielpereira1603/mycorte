<?php

namespace App\Http\Controllers\Client\MyCuts;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Schedule;
use App\Models\ScheduleService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RescheduleClientController extends Controller
{
    public function reschedule(Request $request, $tokenCompany)
    {
        // Validação dos dados do formulário
        $validator = $this->validateScheduleData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company = Company::where('token', $tokenCompany)->first();

        // Convertendo a string de IDs em um array
        $selectedServices = explode(',', $request->input('selectedServicesModal'));

        // Verificação de conflitos de agendamento
        $conflictingSchedules = Schedule::where('date', $request->input('date'))
            ->where('statusSchedulefk', 1) // Verificando apenas agendamentos com status "Agendado"
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('hourStart', '<', $request->input('end'))
                        ->where('hourFinal', '>', $request->input('start'));
                });
            })
            ->exists();

        if ($conflictingSchedules) {
            return redirect()->back()->with('error', 'Já existe um agendamento para a data e horário selecionados. Por favor, escolha outro horário.');
        }

        try {
            // Atualização do status do agendamento existente para "Reagendado"
            $existingSchedule = Schedule::find($request->input('scheduleId'));
            if ($existingSchedule) {
                $existingSchedule->statusSchedulefk = 2; // Status "Reagendado"
                $existingSchedule->save();
            }

            // Criação do novo agendamento
            $schedule = new Schedule();
            $schedule->date = $request->input('date');
            $schedule->hourStart = $request->input('start');
            $schedule->hourFinal = $request->input('end');
            $schedule->clientfk = auth('client')->user()->id; // Ajuste conforme sua lógica de autenticação
            $schedule->collaboratorfk = $request->input('idCollaborator');
            $schedule->statusSchedulefk = 1; // Status padrão "Agendado"
            $schedule->companyfk = $company->id; // Token da empresa
            $schedule->save();

            // Adiciona os serviços relacionados ao novo agendamento
            foreach ($selectedServices as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $scheduleService = new ScheduleService();
                    $scheduleService->schedule_id = $schedule->id;
                    $scheduleService->service_id = $serviceId;
                    $scheduleService->save();
                }
            }

            return redirect()->route('mycutsclient', ['tokenCompany' => $tokenCompany])->with('success', 'Reagendado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao criar o agendamento. Por favor, tente novamente mais tarde.');
        }
    }

    private function validateScheduleData(Request $request)
    {
        return Validator::make($request->all(), [
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'date' => 'required|date_format:Y-m-d',
            'idCollaborator' => 'required|exists:collaborator,id',
            'totalPriceModal' => 'required|numeric',
            'selectedServicesModal' => 'required|string',
        ], [
            'start.required' => 'O campo início é obrigatório.',
            'start.date_format' => 'O campo início deve estar no formato HH:MM.',
            'end.required' => 'O campo fim é obrigatório.',
            'end.date_format' => 'O campo fim deve estar no formato HH:MM.',
            'end.after' => 'O campo fim deve ser posterior ao campo início.',
            'date.required' => 'O campo data é obrigatório.',
            'date.date_format' => 'O campo data deve estar no formato de data válido.',
            'idCollaborator.required' => 'O campo colaborador é obrigatório.',
            'idCollaborator.exists' => 'O colaborador selecionado não existe.',
            'totalPriceModal.required' => 'O campo preço total é obrigatório.',
            'totalPriceModal.numeric' => 'O campo preço total deve ser numérico.',
            'selectedServicesModal.required' => 'O campo serviços selecionados é obrigatório.',
        ]);
    }
}
