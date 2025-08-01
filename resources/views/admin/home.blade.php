@extends('adminlte::page')

@section('title', 'Panel de Administración | SquashPlash')

@section('content_header')
    <h1 class="mt-2 text-center">SQUASH<span>PLASH</span></h1>
    <h2 class="mt-4 text-center">Bienvenido Administrador</h2>
@stop

@section('content')

<div class="row mt-4">
    {{-- Tarjetas Resumen --}}
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-header">
                <i class="fas fa-users"></i> Clientes Registrados
            </div>
            <div class="card-body">
                <h3>{{ $totalClientes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-header">
                <i class="fas fa-user-tie"></i> Empleados Activos
            </div>
            <div class="card-body">
                <h3>{{ $totalEmpleados }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-header">
                <i class="fas fa-swimmer"></i> Clases Hoy
            </div>
            <div class="card-body">
                <h3>{{ $clasesHoy }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-header">
                <i class="fas fa-dollar-sign"></i> Ingresos Mensuales
            </div>
            <div class="card-body">
                <h3>${{ number_format($ingresosMes, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Gráfica opcional o listado de alertas --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-exclamation-circle"></i> Alertas del Sistema
            </div>
            <div class="card-body">
                @if(count($alertas) > 0)
                    <ul>
                        @foreach($alertas as $alerta)
                            <li>{{ $alerta }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay alertas por el momento ✅</p>
                @endif
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        body {
            background: linear-gradient(to right, #dfe9f3, #ffffff);
        }

        h1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            font-weight: bold;
        }

        span {
            font-weight: 200;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            font-weight: bold;
            font-size: 1.1rem;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Bienvenido al panel de administración 🧑‍💼");
    </script>
@stop
