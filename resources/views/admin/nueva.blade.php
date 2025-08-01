@extends('adminlte::page')

@section('title', $clase->id ? 'Editar Clase' : 'Nueva Clase')

@section('content_header')
    <h1>{{ $clase->id ? 'Editar Clase' : 'Nueva Clase' }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <h4>{{ $clase->id ? 'Editar Clase' : 'Crear Nueva Clase' }}</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('clases.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $clase->id ?? 0 }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha">Fecha y Hora *</label>
                            <input type="datetime-local" 
                                   class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha" 
                                   name="fecha" 
                                   value="{{ old('fecha', $clase->fecha ? date('Y-m-d\TH:i', strtotime($clase->fecha)) : '') }}" 
                                   required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_profesor">Profesor *</label>
                            <select class="form-control @error('id_profesor') is-invalid @enderror" 
                                    id="id_profesor" 
                                    name="id_profesor" 
                                    required>
                                <option value="">Seleccione un profesor</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->id }}" 
                                            {{ old('id_profesor', $clase->id_profesor) == $profesor->id ? 'selected' : '' }}>
                                        {{ $profesor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_profesor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo">Tipo de Clase *</label>
                            <input type="text" 
                                   class="form-control @error('tipo') is-invalid @enderror" 
                                   id="tipo" 
                                   name="tipo" 
                                   value="{{ old('tipo', $clase->tipo) }}" 
                                   placeholder="Ej: Yoga, Pilates, Zumba..."
                                   required>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lugares">Lugares Totales *</label>
                            <input type="number" 
                                   class="form-control @error('lugares') is-invalid @enderror" 
                                   id="lugares" 
                                   name="lugares" 
                                   value="{{ old('lugares', $clase->lugares) }}" 
                                   min="1" 
                                   required>
                            @error('lugares')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($clase->id)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lugares_ocupados">Lugares Ocupados</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="lugares_ocupados" 
                                   value="{{ $clase->lugares_ocupados ?? 0 }}" 
                                   readonly>
                            <small class="form-text text-muted">Este campo se actualiza automáticamente</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lugares_disponibles">Lugares Disponibles</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="lugares_disponibles" 
                                   value="{{ $clase->lugares_disponibles ?? $clase->lugares }}" 
                                   readonly>
                            <small class="form-text text-muted">Se calcula automáticamente</small>
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ $clase->id ? 'Actualizar Clase' : 'Crear Clase' }}
                    </button>
                    <a href="{{ route('clases') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop