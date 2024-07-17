<?php
namespace App\Http\Controllers\Client\ServiceBySchedule;

use App\Events\Pusher;
use App\Http\Controllers\Controller;
use App\Mail\CreatedScheduleMail;
use App\Models\Client;
use App\Models\Collaborator;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ScheduleService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InsertServiceByScheduleController extends Controller
{
    public function createSchedule(Request $request, $tokenCompany)
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
            ->where(function($query) use ($request) {
                $query->where(function($query) use ($request) {
                    $query->where('hourStart', '<', $request->input('end'))
                        ->where('hourFinal', '>', $request->input('start'));
                });
            })
            ->exists();

        if ($conflictingSchedules) {
            return redirect()->route('scheduleclient', [
                'tokenCompany' => $tokenCompany,
                'collaboratorId' => $request->input('idCollaborator')
            ])->with('error', 'Já existe um agendamento para a data e horário selecionados. Por favor, escolha outro horário.');
        }

        try {
            // Criação do agendamento
            $schedule = new Schedule();
            $schedule->date = $request->input('date');
            $schedule->hourStart = $request->input('start');
            $schedule->hourFinal = $request->input('end');
            $schedule->clientfk = auth('client')->user()->id; // Ajuste conforme sua lógica de autenticação
            $schedule->collaboratorfk = $request->input('idCollaborator');
            $schedule->statusSchedulefk = 1; // Status padrão
            $schedule->companyfk = $company->id; // Token da empresa
            $schedule->save();

            // Adiciona os serviços relacionados ao agendamento
            $services = [];
            foreach ($selectedServices as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $scheduleService = new ScheduleService();
                    $scheduleService->schedule_id = $schedule->id;
                    $scheduleService->service_id = $serviceId;
                    $scheduleService->save();

                    // Adiciona o serviço ao array de serviços
                    $services[] = [
                        'name' => $service->name,
                        'value' => $service->value,
                    ];
                }
            }

            $formattedDate = Carbon::createFromFormat('Y-m-d', $schedule->date)->format('d-m-Y');
            $client = Client::where('id', $schedule->clientfk)->first();
            $collaborator = Collaborator::where('id', $schedule->collaboratorfk)->first();
            Mail::to($client->email)->send(new CreatedScheduleMail($client, $schedule, $collaborator, $company, $formattedDate));

            // Envia os dados para o Pusher
            (new Pusher())->trigger('schedule', 'create-schedule', [
                'schedule' => $schedule,
                'services' => $services,
                'clientName' => $client->name,
                'clientImage' => $client->image,
                'scheduleDate' => $formattedDate,
                'scheduleStartHour' => $schedule->hourStart,
                'scheduleEndHour' => $schedule->hourFinal,
                'scheduleId' => $schedule->id,
                'hoursUntilStart' => Carbon::parse($schedule->date . ' ' . $schedule->hourStart)->diffInHours(now()),
                'minutesUntilStart' => Carbon::parse($schedule->date . ' ' . $schedule->hourStart)->diffInMinutes(now()) % 60,
            ]);

            return redirect()->route('mycutsclient', ['tokenCompany' => $tokenCompany])->with('success', 'Agendamento criado com sucesso!');
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
            'date.date' => 'O campo data deve estar no formato de data válido.',
            'idCollaborator.required' => 'O campo colaborador é obrigatório.',
            'idCollaborator.exists' => 'O colaborador selecionado não existe.',
            'totalPriceModal.required' => 'O campo preço total é obrigatório.',
            'totalPriceModal.numeric' => 'O campo preço total deve ser numérico.',
        ]);
    }
}
