<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\Client;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SingupClientController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Client.singupClient', ['tokenCompany' => $tokenCompany]);
    }

    public function register(Request $request, $tokenCompany)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'O campo de nome é obrigatório.',
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'telephone.required' => 'O campo de telefone é obrigatório.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        $emailExists = Client::where('email', $request->email)->exists() || Collaborator::where('email', $request->email)->exists();
        $telephoneExists = Client::where('telephone', $request->telephone)->exists() || Collaborator::where('telephone', $request->telephone)->exists();

        if ($emailExists) {
            return back()->withErrors(['email' => 'Este email já está em uso.'])->withInput();
        }

        if ($telephoneExists) {
            return back()->withErrors(['telephone' => 'Este telefone já está em uso.'])->withInput();
        }

        try {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => bcrypt($request->password),
            ]);

            Auth::guard('client')->login($client);

            Mail::to($client->email)->send(new WelcomeMail($client->name));

            $redirectTo = $request->input('redirect_to', route('homeclient', ['tokenCompany' => $tokenCompany]));
            return redirect()->intended($redirectTo)->with('success', 'Cadastro realizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar o cliente. Por favor, tente novamente.'])->withInput();
        }
    }
}
