@extends('layouts.app')

@section('content')

<h2 class="mb-4">Reportes</h2>

<div class="card mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('reportes.index') }}" class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Cliente</label>
                <select name="cliente_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} {{ $cliente->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Desde</label>
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Hasta</label>
                <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>

        </form>

    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white fw-bold">Servicios encontrados</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Servicio</th>
                    <th>Vehículo</th>
                    <th>Cliente</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->vehiculo->marca }} {{ $servicio->vehiculo->modelo }}</td>
                        <td>{{ $servicio->vehiculo->cliente->nombre }} {{ $servicio->vehiculo->cliente->apellido }}</td>
                        <td>{{ number_format($servicio->precio, 2) }}</td>
                        <td>{{ $servicio->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">No se encontraron servicios con esos filtros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-bold">Resumen por mes</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mes</th>
                    <th>Servicios realizados</th>
                    <th>Total ingresos</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumenMensual as $fila)
                    <tr>
                        <td>{{ \Carbon\Carbon::create($fila->anio, $fila->mes)->translatedFormat('F Y') }}</td>
                        <td>{{ $fila->cantidad }}</td>
                        <td>{{ number_format($fila->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Aún no hay datos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection