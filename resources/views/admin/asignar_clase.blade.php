@extends('adminlte::page')

@section('title', isset($asignacion) ? 'Editar asignación' : 'Asignar clase a alumno')

@section('content_header')
    <h1>{{ isset($asignacion) ? 'Editar asignación' : 'Asignar clase a alumno' }}</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ isset($asignacion) ? route('admin.clases.editar', $asignacion->id) : route('admin.clases.asignar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">Alumno:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">---Seleccione un alumno---</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ isset($asignacion) && $asignacion->user_id == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="clase_id">Clase:</label>
            <select name="clase_id" id="clase_id" class="form-control" required>
                <option value="">---Seleccione una clase---</option>
                @foreach($clases as $clase)
                    <option value="{{ $clase->id }}" {{ isset($asignacion) && $asignacion->clase_id == $clase->id ? 'selected' : '' }}>
                        {{ $clase->tipo }} - |Fecha y Hora: {{ $clase->fecha }}| (Lugares Disponibles: {{ $clase->lugares_disponibles }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($asignacion) ? 'Actualizar' : 'Asignar' }}</button>
    </form>
@stop
