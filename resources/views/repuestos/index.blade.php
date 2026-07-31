@extends('layouts.app')

@section('content')

<h2 class="mb-3">Lista de Repuestos</h2>

<a href="{{ route('repuestos.create') }}" class="btn btn-primary mb-3">
    Nuevo Repuesto
</a>

<table class="table table-bordered table-hover">

    <thead class="table-dark">
        <tr>
            <th>Nombre</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Proveedor</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

        @forelse($repuestos as $repuesto)

        <tr>
            <td>{{ $repuesto->nombre }}</td>
            <td>{{ $repuesto->stock }}</td>
            <td>{{ number_format($repuesto->precio, 2) }}</td>
            <td>{{ $repuesto->proveedor }}</td>
            <td>{{ $repuesto->created_at->format('d/m/Y') }}</td>

            <td>
                <a href="{{ route('repuestos.edit',$repuesto) }}" class="btn btn-warning btn-sm">
                    Editar
                </a>

                @if(Auth::user()->isAdmin())
                <form action="{{ route('repuestos.destroy',$repuesto) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar repuesto?')">
                        Eliminar
                    </button>
                </form>
                @endif
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="6" class="text-center">No hay repuestos registrados.</td>
        </tr>
        @endforelse

    </tbody>

</table>

@endsection