<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Servicio;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

    // --- Vista simplificada para empleados ---
    if (!auth()->user()->isAdmin()) {
        return view('dashboard-empleado', [
            'totalClientes'  => Cliente::count(),
            'totalVehiculos' => Vehiculo::count(),
        ]);
    }

    // --- Vista completa para admin (la que ya tenías) ---
    $totalClientes = Cliente::count();
    $totalVehiculos = Vehiculo::count();
    $totalServicios = Servicio::count();
    $totalIngresos = Servicio::sum('precio');
    $ultimosServicios = Servicio::with('vehiculo.cliente')
        ->latest()
        ->take(5)
        ->get();
    $vehiculosPorMarca = Vehiculo::select('marca', DB::raw('count(*) as total'))
        ->groupBy('marca')
        ->orderByDesc('total')
        ->take(5)
        ->get();
    $meses = [];
    $ingresosPorMes = [];

    for ($i = 5; $i >= 0; $i--) {
        $fecha = now()->subMonths($i);
        $meses[] = ucfirst($fecha->translatedFormat('M'));

        $ingresosPorMes[] = Servicio::whereYear('created_at', $fecha->year)
            ->whereMonth('created_at', $fecha->month)
            ->sum('precio');
    }

    return view('dashboard', compact(
        'totalClientes', 'totalVehiculos', 'totalServicios', 'totalIngresos',
        'ultimosServicios', 'vehiculosPorMarca', 'meses', 'ingresosPorMes'
    ));

})->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Módulos disponibles para Admin y Empleado (sin eliminar)
    Route::resource('clientes', ClienteController::class)->except('destroy');
    Route::resource('vehiculos', VehiculoController::class)->except('destroy');
    Route::resource('servicios', ServicioController::class)->except('destroy');
    Route::resource('repuestos', RepuestoController::class)->except('destroy');

    // Rutas exclusivas para Admin
    Route::middleware('admin')->group(function () {

        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
        Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');
        Route::delete('/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
        Route::delete('/repuestos/{repuesto}', [RepuestoController::class, 'destroy'])->name('repuestos.destroy');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

        Route::resource('usuarios', UsuarioController::class)->only(['index', 'create', 'store']);

    });

});

require __DIR__.'/auth.php';