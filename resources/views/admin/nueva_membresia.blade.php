@extends('adminlte::page')

@section('title', $membresia->id ? 'Editar Membresía' : 'Nueva Membresía')

@section('content_header')
    <h1>{{ $membresia->id ? 'Editar Membresía' : 'Nueva Membresía' }}</h1>
@stop

@section('content')
<div class="container">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h4>{{ $membresia->id ? 'Editar Membresía' : 'Registrar Nueva Membresía' }}</h4>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('membresias.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $membresia->id ?? 0 }}">

                <div class="form-group mb-3">
                    <label for="id_usuario">Usuario</label>
                    <select name="id_usuario" class="form-control" required>
                        <option value="">-- Selecciona un usuario --</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $membresia->id_usuario == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }} ({{ $usuario->rol }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="clases_adquiridas">Clases Adquiridas</label>
                    <input type="number" name="clases_adquiridas" class="form-control" min="1"
                        value="{{ old('clases_adquiridas', $membresia->clases_adquiridas ?? '') }}" required>
                </div>

                @if($membresia->id)
                <div class="form-group mb-3">
                    <label for="clases_ocupadas">Clases Ocupadas</label>
                    <input type="number" name="clases_ocupadas" class="form-control" min="0"
                        value="{{ old('clases_ocupadas', $membresia->clases_ocupadas ?? '') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="clases_disponibles">Clases Disponibles</label>
                    <input type="number" name="clases_disponibles" class="form-control" min="0"
                        value="{{ old('clases_disponibles', $membresia->clases_disponibles ?? '') }}">
                </div>
                @endif

                <button type="submit" class="btn btn-success">
                    {{ $membresia->id ? 'Actualizar' : 'Guardar' }}
                </button>

                <a href="{{ route('membresias.lista') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@stop
