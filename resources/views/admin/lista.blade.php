@extends('adminlte::page')

@section('title', 'Clases')

@section('content_header')
    <h1>Clases</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h4>Listado de Clases</h4>
            <a href="{{ route('clases.nueva') }}" class="btn btn-primary float-right">Nueva Clase</a>
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
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Profesor</th>
                        <th>Tipo</th>
                        <th>Lugares Totales</th>
                        <th>Lugares Ocupados</th>
                        <th>Lugares Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clases as $clase)
                    <tr>
                        <td>{{ $clase->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y H:i') }}</td>
                        <td>{{ $clase->profesor ? $clase->profesor->name : 'Sin asignar' }}</td>
                        <td>{{ $clase->tipo }}</td>
                        <td>{{ $clase->lugares }}</td>
                        <td>{{ $clase->lugares_ocupados ?? 0 }}</td>
                        <td>{{ $clase->lugares_disponibles ?? $clase->lugares }}</td>
                        <td>
                            <a href="{{ route('clases.editar', $clase->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('clases.eliminar', $clase->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro quieres eliminar esta clase?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">No hay clases registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop