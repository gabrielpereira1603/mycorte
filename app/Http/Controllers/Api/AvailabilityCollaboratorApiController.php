<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityCollaborator;
use Illuminate\Http\JsonResponse;

class AvailabilityCollaboratorApiController extends Controller
{
    public function getAvailabilityCollaborators($collaboratorId): JsonResponse
    {
        try {
            $availabilities = AvailabilityCollaborator::where('collaboratorfk', $collaboratorId)->get();

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
