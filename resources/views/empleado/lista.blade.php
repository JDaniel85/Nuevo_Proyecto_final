@extends('adminlte::page')

@section('title', 'Clases')

@section('content_header')
    <h1>Clases</h1>
@stop

@section('content')
    <div class="container-fluid">
        <a href="{{ route('clases.nueva') }}" class="btn btn-primary mb-3">Nueva Clase</a>
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Listado de Clases</h4>
            </div>
            <div class="card-body bg-light">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Profesor</th>
                            <th>Tipo</th>
                            <th>Lugares</th>
                            <th>Ocupados</th>
                            <th>Disponibles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clases as $clase)
                        <tr>
                            <td>{{ $clase->id }}</td>
                             <td>{{ $clase->fecha->format('d/m/Y') }}</td>
                            <td>{{ $clase->profesor->name ?? 'N/A' }}</td>
                            <td>{{ $clase->tipo }}</td>
                            <td>{{ $clase->lugares }}</td>
                            <td>{{ $clase->lugares_ocupados }}</td>
                            <td>{{ $clase->lugares_disponibles }}</td>
                            <td>
                                <a href="{{ route('clases.editar', $clase->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('clases.eliminar', $clase->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Eliminar clase?')" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
