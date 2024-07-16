<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ReminderEmail;
use App\Models\Client;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderScheduleClientApiController extends Controller
{
    public function sendReminder($scheduleId)
    {
        try {
            $schedule = Schedule::with('client', 'collaborator', 'company')->findOrFail($scheduleId);
            // Enviar e-mail usando a classe ReminderEmail
            Mail::to($schedule->client->email)->send(new ReminderEmail($schedule));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
