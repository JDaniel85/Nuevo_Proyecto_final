@extends('adminlte::page')

@section('title', 'Clases Asignadas')

@section('content_header')
    <h1>Clases Asignadas</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h4>Listado de Clases Asignadas</h4>
            <a href="{{ route('admin.clases.formAsignar') }}" class="btn btn-primary float-right">Nueva Asignación</a>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID Asignación</th>
                        <th>Alumno</th>
                        <th>Clase</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clasesAsignadas as $asignacion)
                    <tr>
                        <td>{{ $asignacion->asignacion_id }}</td>
                        <td>{{ $asignacion->alumno_nombre }}</td>
                        <td>{{ $asignacion->clase_tipo }}</td>
                        <td>
                            <a href="{{ route('admin.clases.formEditar', $asignacion->asignacion_id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.clases.eliminar', $asignacion->asignacion_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta asignación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">No hay clases asignadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
