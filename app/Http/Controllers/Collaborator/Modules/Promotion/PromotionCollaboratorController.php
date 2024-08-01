<?php

namespace App\Http\Controllers\Collaborator\Modules\Promotion;

use App\Http\Controllers\Controller;

class PromotionCollaboratorController extends Controller
{
    public function index($tokenCompany)
    {
        return view('Collaborator.Modules.Promotion.index',[
            'tokenCompany' => $tokenCompany,
        ]);
    }
}
