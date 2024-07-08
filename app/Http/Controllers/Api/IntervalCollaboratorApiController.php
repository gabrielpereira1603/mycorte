<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IntervalCollaborator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntervalCollaboratorApiController extends Controller
{
    public function getIntervalCollaborators($collaboratorId): JsonResponse
    {
        try {
            $availabilities = IntervalCollaborator::where('collaboratorfk', $collaboratorId)->get();

            return response()->json([
                'success' => true,
                'data' => $availabilities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar as disponibilidades do colaborador.'
            ], 500);
        }
    }
}
