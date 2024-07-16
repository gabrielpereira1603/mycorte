<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CaptureEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CaptureEmailController extends Controller
{
    public function send(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $email = $request->input('email');

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new CaptureEmail($email));

            return back()->with('success', 'Seu email foi capturado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao capturar email: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao capturar email.'], 500);
        }
    }


}
