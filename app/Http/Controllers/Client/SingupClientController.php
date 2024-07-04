<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SingupClientController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Client.singupClient', ['tokenCompany' => $tokenCompany]);
    }

    public function register(Request $request, $tokenCompany)
    {
        // Validação dos dados com mensagens personalizadas
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:client',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'O campo de nome é obrigatório.',
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'telephone.required' => 'O campo de telefone é obrigatório.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        try {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => bcrypt($request->password),
            ]);

            // Autentica o cliente recém-criado
            Auth::guard('client')->login($client);

            // Redireciona para a URL de origem ou para a rota de homeclient se não houver URL de origem
            $redirectTo = $request->input('redirect_to', route('homeclient', ['tokenCompany' => $tokenCompany]));
            return redirect()->intended($redirectTo)->with('success', 'Cadastro realizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar o cliente. Por favor, tente novamente.'])->withInput();
        }
    }
}
