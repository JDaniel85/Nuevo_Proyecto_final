@extends('adminlte::page')

@section('title', $usuario->id ? 'Editar Usuario' : 'Nuevo Usuario')

@section('content_header')
    <h1>{{ $usuario->id ? 'Editar Usuario' : 'Nuevo Usuario' }}</h1>
@stop

@section('content')
<div class="container">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">{{ $usuario->id ? 'Editar Usuario' : 'Registrar Nuevo Usuario' }}</h4>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('usuarios.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $usuario->id ?? 0 }}">

                <div class="form-group mb-3">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name" value="{{ $usuario->name ?? '' }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" value="{{ $usuario->email ?? '' }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="rol">Rol</label>
                    <select name="rol" class="form-control" required>
                        <option value="">Selecciona un rol</option>
                        <option value="Admin" {{ $usuario->rol == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Cliente" {{ $usuario->rol == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Empleado" {{ $usuario->rol == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" {{ $usuario->id ? '' : 'required' }}>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" {{ $usuario->id ? '' : 'required' }}>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ $usuario->id ? 'Actualizar' : 'Guardar' }}
                </button>

                <a href="{{ route('usuarios') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }
    body {
        background: linear-gradient(to bottom, #e0f7fa, #ffffff);
    }
</style>
@stop

@section('js')
    <script> console.log("Formulario de usuarios activo."); </script>
@stop
