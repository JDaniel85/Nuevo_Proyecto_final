@extends('adminlte::page')

@section('title', 'Nueva Clase')

@section('content_header')
    <h1>Registrar Nueva Clase</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">Formulario de Clase</div>
            <div class="card-body">
                <form action="{{ route('clases.guardar') }}" method="POST">
                    @csrf

                    {{-- Este hidden es importante para diferenciar entre crear o editar --}}
                    <input type="hidden" name="id" value="{{ $clase->id ?? 0 }}">

                    <div class="form-group mb-3">
                        <label>Fecha</label>
                         <input type="date" class="form-control" name="fecha"
           value="{{ old('fecha', isset($clase->fecha) ? \Carbon\Carbon::parse($clase->fecha)->format('Y-m-d') : '') }}"
           required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Profesor</label>
                        <select name="id_profesor" class="form-control" required>
                            <option value="">-- Selecciona un Instructor --</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}"
                                    {{ $clase->id_profesor == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tipo de Clase</label>
                        <input type="text" name="tipo" class="form-control" value="{{ $clase->tipo ?? '' }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Cantidad de Lugares</label>
                        <input type="number" name="lugares" class="form-control" value="{{ $clase->lugares ?? '' }}" required min="1">
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@stop
