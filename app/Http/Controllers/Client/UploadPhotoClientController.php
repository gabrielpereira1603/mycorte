<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadPhotoClientController extends Controller
{
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtém o cliente autenticado
        $client = Auth::guard('client')->user();

        if ($client) {
            // Verifica se o cliente já tem uma foto de perfil e a exclui do diretório
            if ($client->image) {
                $oldPath = str_replace(asset('storage/app/public/'), '', $client->image);
                Storage::disk('public')->delete($oldPath);
            }

            // Armazena a nova foto e obtém o caminho
            $path = $request->file('photo')->store('profile_photos/client', 'public');

            // Obtém a URL completa da nova foto armazenada
            $fullPath = asset('storage/app/public/' . $path);

            // Salva o caminho completo da nova foto no banco de dados
            $client->image = $fullPath;
            $client->save();

            // Define a mensagem de sucesso na sessão
            return redirect()->back()->with('success', 'Foto de perfil atualizada com sucesso!');
        }

        // Define a mensagem de erro na sessão
        return redirect()->back()->with('error', 'Falha ao atualizar a foto de perfil. Por favor, tente novamente.');
    }
}
