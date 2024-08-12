<?php

namespace App\Http\Controllers\Collaborator\Modules\Promotion;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        $collaborator = Auth::guard('collaborator')->user();

        // Filtra as promoções do colaborador logado e carrega os serviços associados
        $promotions = Promotion::where('collaboratorfk', $collaborator->id)
            ->with('services')
            ->get();

        // Filtra os serviços do colaborador logado
        $services = Service::where('collaboratorfk', $collaborator->id)->get();

        return view('Collaborator.Modules.Promotion.index', [
            'tokenCompany' => $tokenCompany,
            'promotions' => $promotions,
            'services' => $services,
            'collaborator' => $collaborator
        ]);
    }

    public function addIndividualPromotion(Request $request, $tokenCompany)
    {
        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'dataHourStart' => 'required|date_format:Y-m-d\TH:i',
            'dataHourFinal' => 'required|date_format:Y-m-d\TH:i|after:dataHourStart',
            'value' => 'required|numeric|min:0',
            'enabled' => 'boolean',
            'servicefk' => 'required|exists:service,id',
        ]);

        $collaborator = Auth::guard('collaborator')->user();

        // Validação adicional para garantir que o valor da promoção seja menor que o valor do serviço original
        $service = Service::find($request->servicefk);
        if ($request->value >= $service->value) {
            return back()->withErrors(['value' => 'O valor da promoção deve ser menor que o valor original do serviço.']);
        }

        $promotion = new Promotion();
        $promotion->name = $request->name;
        $promotion->dataHourStart = $request->dataHourStart;
        $promotion->dataHourFinal = $request->dataHourFinal;
        $promotion->value = $request->value;
        $promotion->enabled = $request->boolean('enabled');
        $promotion->type = 'individual';
        $promotion->companyfk = $collaborator->companyfk;
        $promotion->collaboratorfk = $collaborator->id;
        $promotion->save();

        // Associando serviço à promoção
        $promotion->services()->attach($request->servicefk);

        return redirect()->route('promotioncollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Promoção individual adicionada com sucesso!');
    }

    public function addComboPromotion(Request $request, $tokenCompany)
    {
        // Validação dos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'dataHourStart' => 'required|date_format:Y-m-d\TH:i',
            'dataHourFinal' => 'required|date_format:Y-m-d\TH:i|after:dataHourStart',
            'value' => 'required|numeric|min:0',
            'enabled' => 'boolean',
            'services' => 'required|array',
            'services.*' => 'exists:service,id'
        ]);

        $collaborator = Auth::guard('collaborator')->user();

        $promotion = new Promotion();
        $promotion->name = $request->name;
        $promotion->dataHourStart = $request->dataHourStart;
        $promotion->dataHourFinal = $request->dataHourFinal;
        $promotion->value = $request->value;
        $promotion->enabled = $request->boolean('enabled');
        $promotion->type = 'combo';
        $promotion->companyfk = $collaborator->companyfk;
        $promotion->collaboratorfk = $collaborator->id;
        $promotion->save();

        // Associando serviços à promoção
        $promotion->services()->attach($request->services);

        return redirect()->route('promotioncollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Promoção combo adicionada com sucesso!');
    }


    public function editPromotion(Request $request, $tokenCompany)
    {
        // Validação dos campos
        $request->validate([
            'promotion_id' => 'required|exists:promotion,id',
            'name' => 'required|string|max:255',
            'dataHourStart' => 'required|date_format:Y-m-d\TH:i',
            'dataHourFinal' => 'required|date_format:Y-m-d\TH:i|after:dataHourStart',
            'value' => 'required|numeric|min:0',
            'enabled' => 'boolean',
            'type' => 'required|in:individual,combo',
            'servicefk' => 'required_if:type,individual|exists:service,id',
            'services' => 'required_if:type,combo|array',
            'services.*' => 'exists:service,id'
        ]);

        $promotion = Promotion::with('services')->find($request->promotion_id);

        // Validação adicional para garantir que o valor da promoção seja menor que o valor do serviço original
        if ($request->type == 'individual') {
            $service = Service::find($request->servicefk);
            if ($request->value >= $service->value) {
                return back()->withErrors(['value' => 'O valor da promoção deve ser menor que o valor original do serviço.']);
            }
        }

        $promotion->name = $request->name;
        $promotion->dataHourStart = $request->dataHourStart;
        $promotion->dataHourFinal = $request->dataHourFinal;
        $promotion->value = $request->value;
        $promotion->enabled = $request->boolean('enabled');
        $promotion->type = $request->type;
        $promotion->save();

        // Atualizando a associação de serviços
        if ($request->type == 'combo') {
            $promotion->services()->sync($request->services);
        } else {
            $promotion->services()->sync([$request->servicefk]);
        }

        return redirect()->route('promotioncollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Promoção atualizada com sucesso!');
    }

    public function deletePromotion(Request $request, $tokenCompany)
    {
        $promotion = Promotion::find($request->id);
        if ($promotion) {
            $promotion->delete();
        }

        return redirect()->route('promotioncollaborator', ['tokenCompany' => $tokenCompany])
            ->with('success', 'Promoção deletada com sucesso.');
    }
}
