@extends('adminlte::page')

@section('title', 'Membresias')

@section('content_header')
    <h1>Membresias</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Listado de Membresías</h4>
            </div>
            <div class="card-body bg-light">
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>ID Usuario</th>
                            <th>Clases Adquiridas</th>
                            <th>Clases Ocupadas</th>
                            <th>Clases Disponibles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($membresias as $membresia)
                        <tr>
                            <td> {{$membresia->id}} </td>
                            <td> {{$membresia->cliente}} </td>
                            <td>{{$membresia->clases_adquiridas}}</td>
                            <td> {{$membresia->clases_ocupadas}} </td>
                            <td>{{$membresia->clases_disponibles}}</td>
                            <td>
                                <a href="{{route('membresias.editar', $membresia->id)}}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('membresias.eliminar', $membresia->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta membresía?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        {{-- Aquí puedes agregar más registros dinámicamente --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop