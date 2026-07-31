@extends('layouts.app')

@section('content')

<h2 class="mb-3">Editar Repuesto</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('repuestos.update', $repuesto) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $repuesto->nombre) }}">
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $repuesto->stock) }}">
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio', $repuesto->precio) }}">
    </div>

    <div class="mb-3">
        <label for="proveedor" class="form-label">Proveedor</label>
        <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ old('proveedor', $repuesto->proveedor) }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>

</form>

@endsection