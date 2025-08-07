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
            @if($clases->isEmpty())
                <div class="alert alert-warning">
                    <strong>¡Atención!</strong> No hay clases disponibles en este momento. Intenta más tarde o contacta a administración.
                </div>
            @else
                <select name="clase_id" id="clase_id" class="form-control" required>
                    <option value="">---Seleccione una clase---</option>
                    @foreach($clases as $clase)
                        <option value="{{ $clase->id }}" {{ isset($asignacion) && $asignacion->clase_id == $clase->id ? 'selected' : '' }}>
                            {{ $clase->tipo }} - |Fecha y Hora: {{ $clase->fecha }}| (Lugares Disponibles: {{ $clase->lugares_disponibles }})
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <!-- Contenedor para mostrar los detalles de la clase seleccionada -->
        <div id="clase-detalles" class="mt-3"></div>

        <button type="submit" class="btn btn-success mt-3">{{ isset($asignacion) ? 'Actualizar' : 'Asignar' }}</button>
    </form>
@stop

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clasesData = @json($clases->keyBy('id'));
        const claseSelect = document.getElementById('clase_id');
        const detallesContainer = document.getElementById('clase-detalles');

        claseSelect.addEventListener('change', function() {
            const selectedId = this.value;
            detallesContainer.innerHTML = ''; // Limpiar detalles anteriores

            if (selectedId && clasesData[selectedId]) {
                const clase = clasesData[selectedId];
                
                const detailsHtml = `
                    <div class="card bg-light">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><strong>Detalles de la Clase</strong></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Duración:</strong> ${clase.duracion || 'No especificado'}</p>
                            <p class="mb-1"><strong>Nivel:</strong> ${clase.nivel || 'No especificado'}</p>
                            <p class="mb-0"><strong>Público:</strong> ${clase.publico_dirigido || 'No especificado'}</p>
                        </div>
                    </div>
                `;
                
                detallesContainer.innerHTML = detailsHtml;
            }
        });

        // Disparar el evento change al cargar la página si ya hay una clase seleccionada (para modo edición)
        if (claseSelect.value) {
            claseSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
