<?php

namespace App\Http\Controllers\Client\MyCuts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RescheduleClientController extends Controller
{
    public function reschedule(Request $request, $tokenCompany){
        dd($request->all());
    }
}
