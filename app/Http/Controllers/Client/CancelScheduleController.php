<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mails\CancelScheduleMailController;
use App\Mail\CancellationMail;
use App\Models\Company;
use App\Models\Schedule;
use App\Models\StatusSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class CancelScheduleController extends Controller
{
    public function cancel(Request $request, $tokenCompany, $scheduleId)
    {
        $client = Auth::guard('client')->user();
        $company = Company::where('token', $tokenCompany)->firstOrFail();
        $schedule = Schedule::where('id', $scheduleId)->where('clientfk', $client->id)->where('companyfk', $company->id)->firstOrFail();

        $currentDateTime = Carbon::now();
        $scheduleDateTime = Carbon::parse($schedule->date . ' ' . $schedule->hourStart);

        if ($currentDateTime->diffInMinutes($scheduleDateTime, false) < 60) {
            return Redirect::back()->with('error', 'O agendamento não pode ser cancelado com menos de 1 hora de antecedência.');
        }

        $statusSchedule = StatusSchedule::where('status', 'Cancelado')->firstOrFail();
        $schedule->statusSchedulefk = $statusSchedule->id;
        $schedule->save();

        Mail::to($client->email)->send(new CancellationMail($client->name, $company->name));

        return Redirect::route('mycutsclient', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Agendamento cancelado com sucesso!');
    }
}
