<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class UploadPhotoClientController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Armazena a foto e obtém o caminho
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Obtém a URL completa da foto armazenada
        $fullPath = asset('storage/app/public/' . $path);

        // Obtém o cliente autenticado
        $client = Auth::guard('client')->user();

        if ($client) {
            // Salva o caminho completo da foto no banco de dados
            $client->image = $fullPath;
            $client->save();

            // Define a mensagem de sucesso na sessão
            return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
        }

        // Define a mensagem de erro na sessão
        return redirect()->back()->with('error', 'Falha ao atualizar a foto de perfil. Por favor, tente novamente.');
    }
}
