<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicio::with('vehiculo.cliente');

        if ($request->filled('cliente_id')) {
            $query->whereHas('vehiculo', function ($q) use ($request) {
                $q->where('cliente_id', $request->cliente_id);
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $servicios = $query->latest()->get();
        $clientes = Cliente::orderBy('nombre')->get();

        $resumenMensual = Servicio::selectRaw('EXTRACT(YEAR FROM created_at) as anio, EXTRACT(MONTH FROM created_at) as mes, SUM(precio) as total, COUNT(*) as cantidad')
            ->groupBy('anio', 'mes')
            ->orderByDesc('anio')
            ->orderByDesc('mes')
            ->take(12)
            ->get();

        return view('reportes.index', compact('servicios', 'clientes', 'resumenMensual'));
    }
}