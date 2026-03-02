<?php

namespace App\Http\Controllers;

use App\Models\ServiceCounter;
use App\Models\SystemSetting;
use App\Models\Turn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TurnController extends Controller
{
    /**
     * Genera un turno para el cliente autenticado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|in:ventanilla,asesor',
            'tramite' => 'nullable|string|max:100',
        ]);

        $user = $request->user();

        // Verificar que la generación esté activa
        if (! SystemSetting::isTurnGenerationActive()) {
            return back()->with('error', 'La generación de turnos no está activa. Contacte al administrador.');
        }

        // Verificar que el usuario no tenga un turno activo
        if (Turn::userHasActiveTurn($user->id)) {
            return back()->with('error', 'Ya tienes un turno activo.');
        }

        $serviceType = $request->input('service_type');
        $tramite = $request->input('tramite');

        // Buscar la ventanilla/asesor con menos carga, SOLO de counters activos con operador asignado
        $activeLabels = User::where('role', 'operador')
            ->whereNotNull('area_designada')
            ->pluck('area_designada');

        $counter = ServiceCounter::where('type', $serviceType)
            ->whereIn('label', $activeLabels)
            ->orderBy('active_clients', 'asc')
            ->first();

        if (! $counter) {
            return back()->with('error', 'No hay ventanillas/asesores disponibles en este momento.');
        }

        // Usar transacción para evitar condiciones de carrera
        $turn = DB::transaction(function () use ($counter, $user, $serviceType, $tramite) {
            // Bloquear el registro para evitar concurrencia
            $counter = ServiceCounter::lockForUpdate()->find($counter->id);

            $turnNumber = $counter->getNextTurnNumber();

            $counter->increment('active_clients');

            return Turn::create([
                'user_id' => $user->id,
                'service_counter_id' => $counter->id,
                'turn_number' => $turnNumber,
                'service_type' => $serviceType,
                'tramite' => $tramite,
                'status' => 'waiting',
            ]);
        });

        $turn->load('serviceCounter');

        if ($serviceType === 'ventanilla') {
            return redirect()->route('nova.ventanilla.asignado')
                ->with('turn', $turn);
        }

        return redirect()->route('nova.asesor.asignado')
            ->with('turn', $turn);
    }

    /**
     * Cancela el turno activo del cliente.
     */
    public function cancel(Request $request)
    {
        $user = $request->user();

        $turn = Turn::getUserActiveTurn($user->id);

        if (! $turn) {
            return redirect()->route('nova.index')->with('error', 'No tienes un turno activo.');
        }

        DB::transaction(function () use ($turn) {
            $turn->update(['status' => 'cancelled']);

            $counter = ServiceCounter::lockForUpdate()->find($turn->service_counter_id);
            if ($counter && $counter->active_clients > 0) {
                $counter->decrement('active_clients');
            }
        });

        return redirect()->route('nova.index')->with('success', 'Tu turno ha sido cancelado.');

    }

    /**
     * Muestra el turno activo del usuario (API/JSON para refrescar vista).
     */
    public function activeTurn(Request $request)
    {
        $userId = $request->user()->id;
        $turn = Turn::getUserActiveTurn($userId);

        if (! $turn) {
            $last = Turn::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json([
                'has_turn' => false,
                'last_status' => $last?->status,
            ]);
        }

        $ahead = Turn::where('status', 'waiting')
            ->where('service_counter_id', $turn->service_counter_id)
            ->where('created_at', '<', $turn->created_at)
            ->count();
        $etaSeconds = $ahead * 10 * 60;

        return response()->json([
            'has_turn' => true,
            'turn_number' => $turn->turn_number,
            'counter_label' => $turn->serviceCounter->label,
            'status' => $turn->status,
            'service_type' => $turn->service_type,
            'eta_seconds' => $etaSeconds,
        ]);
    }
}
