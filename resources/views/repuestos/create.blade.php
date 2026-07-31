@extends('layouts.app')

@section('content')

<h2 class="mb-3">Nuevo Repuesto</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('repuestos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio') }}">
    </div>

    <div class="mb-3">
        <label for="proveedor" class="form-label">Proveedor</label>
        <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ old('proveedor') }}">
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>

</form>

@endsection