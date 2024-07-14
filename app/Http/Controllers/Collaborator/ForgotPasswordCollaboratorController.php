<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ForgotPasswordCollaboratorController extends Controller
{
    public function resetPasswordEmail(Request $request, $tokenCompany)
    {
        Log::info('Reset password email request received', ['request' => $request->all()]);

        // Validação do e-mail
        $request->validate([
            'email' => 'required|email',
        ]);

        // Geração do token de 6 dígitos
        $token = mt_rand(100000, 999999);

        // Armazenar o token na tabela collaborator
        $collaborator = DB::table('collaborator')
            ->where('email', $request->email)
            ->first();

        if ($collaborator) {
            DB::table('collaborator')
                ->where('email', $request->email)
                ->update(['resetpasswordtoken' => $token]);

            // Colocar o token na sessão com duração de 5 minutos
            Session::put('resetpasswordtoken', $token);
            Session::put('resetpasswordtoken_expiration', Carbon::now()->addMinutes(5));

            // Enviar o e-mail com o token e o link
            Mail::to($collaborator->email)->send(new PasswordResetMail($collaborator->name, $token));

            // Redirecionar o usuário para a view de redefinição de senha
            return response()->json(['message' => 'Email enviado com sucesso!']);
        }
        return response()->json(['error' => 'E-mail não encontrado.'], 404);
    }

    public function indexTokenForgotPassword(Request $request, $tokenCompany){
        return view('Collaborator.Login.validateToken',['tokenCompany' => $tokenCompany]);
    }

    public function validateToken(Request $request,$tokenCompany){
        // Validação dos campos individuais
        $request->validate([
            'token_part1' => 'required|array|size:3',
            'token_part1.*' => 'required|digits:1',
            'token_part2' => 'required|array|size:3',
            'token_part2.*' => 'required|digits:1',
        ]);

        // Combinar os valores dos campos do token
        $token = implode('', $request->token_part1) . implode('', $request->token_part2);

        // Verificar se o token na sessão bate com o token no banco de dados
        $collaborator = DB::table('collaborator')->where('resetpasswordtoken', Session::get('resetpasswordtoken'))->first();
        if ($collaborator->resetPasswordToken !== $token) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])->with('error', 'Token inválido.');
        }

        // Redirecionar para a tela de redefinição de senha
        return redirect()->route('resetPasswordCollaboratorView', ['tokenCompany' => $tokenCompany]);
    }

    public function resetPasswordIndex($tokenCompany)
    {
        return view('Collaborator.Login.resetPassword', ['tokenCompany' => $tokenCompany]);
    }

    public function resetPassword(Request $request, $tokenCompany)
    {
        // Validação das senhas fornecidas pelo usuário
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Senha e confirmação
        ]);

        // Validação do token na sessão
        if (!Session::has('resetpasswordtoken') || !Session::has('resetpasswordtoken_expiration')) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])
                ->with('error', 'Token inválido ou expirado.');
        }

        // Verificar se a sessão expirou
        if (Carbon::now()->greaterThan(Session::get('resetpasswordtoken_expiration'))) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])
                ->with('error', 'Token expirado.');
        }

        // Verificar se o token na sessão bate com o token no banco de dados
        $collaborator = DB::table('collaborator')
            ->where('resetPasswordToken', Session::get('resetpasswordtoken'))
            ->first();

        if (!$collaborator) {
            return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])
                ->with('error', 'Token inválido.');
        }

        // Atualizar a senha do colaborador
        DB::table('collaborator')
            ->where('id', $collaborator->id)
            ->update([
                'password' => bcrypt($request->password), // Criptografa a nova senha
                'resetPasswordToken' => null, // Limpar o token de redefinição
            ]);

        // Limpar o token e a data de expiração da sessão
        Session::forget('resetpasswordtoken');
        Session::forget('resetpasswordtoken_expiration');

        // Redirecionar para a página de login com uma mensagem de sucesso
        return redirect()->route('logincollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
    }
}
