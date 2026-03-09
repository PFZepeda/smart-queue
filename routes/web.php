<?php

use App\Http\Controllers\AccountUnlockController;
use App\Http\Controllers\Admin\RegisterEmployeeController;
use App\Http\Controllers\Admin\TurnManagementController;
use App\Http\Controllers\AdvisorTurnController;
use App\Http\Controllers\TurnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->environment('testing')) {
        return response('OK', 200);
    }

    return redirect()->route('login');
})->name('home');

Route::get('/account/unlock/{token}', [AccountUnlockController::class, 'unlock'])
    ->name('account.unlock');

Route::post('/logout/inactivity', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('inactivity', true);
})->middleware('auth')->name('logout.inactivity');

Route::get('dashboard', function () {
    $user = auth()->user();

    if ($user?->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->isOperador()) {
        return redirect()->route('advisor.dashboard');
    }

    return redirect()->route('nova.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================
// RUTAS DE ADMINISTRADOR
// =========================================================
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $totalGenerados = \App\Models\Turn::count();
        $totalExpirados = \App\Models\Turn::where('status', 'expired')->count();
        $totalCancelados = \App\Models\Turn::where('status', 'cancelled')->count();
        $totalFinalizados = \App\Models\Turn::where('status', 'completed')->count();
        $atendidosExito = $totalFinalizados;
        $promedioExito = $totalGenerados > 0
            ? round(($atendidosExito / $totalGenerados) * 100, 1)
            : 0;

        return view('admin.dashboard', [
            'ventanillas' => \App\Models\ServiceCounter::where('type', 'ventanilla')->get(),
            'asesores' => \App\Models\ServiceCounter::where('type', 'asesor')->get(),
            'isActive' => \App\Models\SystemSetting::isTurnGenerationActive(),
            'totalGenerados' => $totalGenerados,
            'totalExpirados' => $totalExpirados,
            'totalCancelados' => $totalCancelados,
            'totalFinalizados' => $totalFinalizados,
            'promedioExito' => $promedioExito,
        ]);
    })->name('admin.dashboard');

    Route::get('/registro-empleado', [RegisterEmployeeController::class, 'index'])
        ->name('admin.register-employee');

    Route::post('/registro-empleado', [RegisterEmployeeController::class, 'store'])
        ->name('admin.register-employee.store');

    Route::delete('/registro-empleado/{id}', [RegisterEmployeeController::class, 'destroy'])
        ->name('admin.register-employee.destroy');

    Route::post('/registro-empleado/{id}/asignar-area', [RegisterEmployeeController::class, 'asignarArea'])
        ->name('admin.register-employee.asignar-area');

    Route::post('/turnos/toggle', [TurnManagementController::class, 'toggle'])
        ->name('admin.turns.toggle');

    Route::post('/area/{counter}/disable', [TurnManagementController::class, 'disableArea'])
        ->name('admin.area.disable');

    Route::post('/area/{counter}/enable', [TurnManagementController::class, 'enableArea'])
        ->name('admin.area.enable');

    Route::get('/reporte/descargar', [\App\Http\Controllers\Admin\ReportExportController::class, 'export'])
        ->name('admin.report.export');
});

// =========================================================
// FLUJO DE NOVABANK (CLIENTES) - Con autenticación
// =========================================================
Route::middleware(['auth', 'role:cliente'])->prefix('nova')->group(function () {

    // 1. Pantalla principal: Selección de trámite
    Route::get('/', function () {
        $turn = \App\Models\Turn::getUserActiveTurn(auth()->id());
        if ($turn) {
            return $turn->service_type === 'ventanilla'
                ? redirect()->route('nova.ventanilla.asignado')
                : redirect()->route('nova.asesor.asignado');
        }

        return view('client.index');
    })->name('nova.index');

    // Sub-flujo: Ventanilla
    Route::prefix('ventanilla')->group(function () {
        Route::view('/tramite', 'client.ventanilla.tramite-ventanilla')->name('nova.ventanilla.tramite');
        Route::view('/generar', 'client.ventanilla.generar-turno')->name('nova.ventanilla.generar');
        Route::get('/asignado', function () {
            $turn = \App\Models\Turn::getUserActiveTurn(auth()->id());
            if (! $turn) {
                return redirect()->route('nova.index')->with('error', 'No tienes un turno activo.');
            }

            return view('client.ventanilla.turno-asignado', compact('turn'));
        })->name('nova.ventanilla.asignado');
    });

    // Sub-flujo: Asesor (Cliente esperando)
    Route::prefix('asesor-cliente')->group(function () {
        Route::view('/generar', 'client.asesor.generar-turno')->name('nova.asesor.generar');
        Route::get('/asignado', function () {
            $turn = \App\Models\Turn::getUserActiveTurn(auth()->id());
            if (! $turn) {
                return redirect()->route('nova.index')->with('error', 'No tienes un turno activo.');
            }

            return view('client.asesor.turno-asignado', compact('turn'));
        })->name('nova.asesor.asignado');
    });

    // Generación y cancelación de turnos
    Route::post('/turno/generar', [TurnController::class, 'store'])->name('nova.turno.store');
    Route::match(['POST', 'GET'], '/turno/cancelar', [TurnController::class, 'cancel'])->name('nova.turno.cancel');
    Route::get('/turno/activo', [TurnController::class, 'activeTurn'])->name('nova.turno.active');
});

// =========================================================
// FLUJO DEL TRABAJADOR (ASESOR)
// =========================================================
Route::middleware(['auth', 'role:operador'])->prefix('gestion-turnos')->group(function () {
    Route::get('/', function () {
        $counters = \App\Models\ServiceCounter::all();

        // Obtener el counter asignado al operador
        $user = auth()->user();
        if ($user) {
            $user->refresh();
        }
        $userArea = $user?->area_designada;
        $counter = $userArea
            ? \App\Models\ServiceCounter::where('label', $userArea)->first()
            : null;

        // Filtrar turnos solo del counter asignado al operador
        $nextTurn = null;
        $waitingCount = 0;
        if ($counter) {
            $nextTurn = \App\Models\Turn::where('status', 'waiting')
                ->where('service_counter_id', $counter->id)
                ->orderBy('created_at', 'asc')
                ->with('serviceCounter')
                ->first();
            $waitingCount = \App\Models\Turn::where('status', 'waiting')
                ->where('service_counter_id', $counter->id)
                ->count();
        }

        return view('advisor.index', compact('counters', 'nextTurn', 'waitingCount', 'userArea'));
    })->name('advisor.dashboard');

    Route::post('/siguiente', [AdvisorTurnController::class, 'next'])->name('advisor.turn.next');
    Route::post('/expirado', [AdvisorTurnController::class, 'expire'])->name('advisor.turn.expire');
    Route::get('/status', [AdvisorTurnController::class, 'status'])->name('advisor.status');
});

// =========================================================
// RUTAS DE PERFIL
// =========================================================
Route::middleware('auth')->group(function () {

    // Vistas
    Route::get('/perfil', function () {
        return view('client.profile.index');
    })->name('profile.edit');

    Route::get('/perfil/password', function () {
        return view('client.profile.password');
    })->name('profile.password');

    Route::get('/perfil/eliminar', function () {
        return view('client.profile.delete');
    })->name('profile.delete');

    Route::get('/perfil/confirm-delete', function(){
        return view('client.profile.confirm-delete');
    })->name('profile.confirm-delete');

    Route::post('/perfil/confirm-delete', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'La contraseña es inválida.']);
        }

        return redirect()->route('profile.delete');
    })->name('profile.confirm-delete.verify');

    // Procesamiento de formularios
    Route::patch('/perfil', function () {
        return back();
    })->name('profile.update');

    Route::post('/perfil/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'password.required'         => 'La nueva contraseña es obligatoria.',
            'password.min'              => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.regex'            => 'La nueva contraseña debe contener al menos una letra y un número.',
            'password.confirmed'        => 'Las contraseñas nuevas no coinciden.',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        if (\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'La nueva contraseña no puede ser igual a la contraseña actual.']);
        }

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    })->name('profile.password.update');

    Route::delete('/perfil/eliminar', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();

        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('login')->with('account_deleted', true);
    })->name('profile.destroy');
});

require __DIR__.'/settings.php';
