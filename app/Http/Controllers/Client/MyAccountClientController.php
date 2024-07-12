<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountClientController extends Controller
{
    public function index($tokenCompany){
        // Obter o cliente autenticado usando Auth::guard('client')->user()
        $client = Auth::guard('client')->user();

        return view('Client.myaccountClient', [
            'tokenCompany' => $tokenCompany,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $tokenCompany)
    {
        $client = Auth::guard('client')->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        $client->update($validatedData);

        return redirect()->route('myaccountclient', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Informações atualizadas com sucesso.');
    }


}
