<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDemoAppointmentRequest;
use App\Models\DemoAppointment;
use Illuminate\Http\JsonResponse;

class DemoAppointmentController extends Controller
{
    public function store(StoreDemoAppointmentRequest $request): JsonResponse
    {
        $appointment = DemoAppointment::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Demonstração agendada com sucesso.',
            'data' => $appointment,
        ], 201);
    }
}
