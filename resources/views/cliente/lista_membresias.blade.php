@extends('adminlte::page')

@section('title', 'Mis Membresías | SquashPlash')

@section('content_header')
    <h1 class="text-center mb-4" style="font-family: 'Segoe UI', sans-serif; font-weight: 700;">
        Tus Membresías en <span style="color: #00B2FF;">Squash</span><span style="color: #00E0FF;">Plash</span>
    </h1>
@stop

@section('content')
<div class="container-fluid px-4">
    <div class="card border-0 shadow-lg" style="background: linear-gradient(to right, #e0f7fa, #ffffff); border-radius: 1.2rem;">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($membresias->count() > 0)
                <div class="row">
                    @foreach($membresias as $membresia)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                                <div class="card-header text-white" style="background-color: #00bcd4; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    <h5 class="mb-0"><i class="fas fa-water"></i> Membresía</h5>
                                </div>
                                <div class="card-body bg-white">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h4 class="text-primary">{{ $membresia->clases_adquiridas }}</h4>
                                            <small class="text-muted">Clases Adquiridas</small>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="text-warning">{{ $membresia->clases_ocupadas ?? 0 }}</h4>
                                            <small class="text-muted">Clases que has Ocupado</small>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="text-success">{{ $membresia->clases_disponibles ?? $membresia->clases_adquiridas }}</h4>
                                            <small class="text-muted">Clases que te quedan</small>
                                        </div>
                                    </div>

                                    <hr>

                                    @php
                                        $porcentaje = $membresia->clases_adquiridas > 0 
                                            ? (($membresia->clases_ocupadas ?? 0) / $membresia->clases_adquiridas) * 100 
                                            : 0;
                                    @endphp

                                    <div class="progress mb-2" style="height: 18px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $porcentaje }}%">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>

                                    <small class="text-muted"><i class="fas fa-info-circle"></i> Usadas: {{ $membresia->clases_ocupadas ?? 0 }} de {{ $membresia->clases_adquiridas }}</small>

                                    @if(($membresia->clases_disponibles ?? $membresia->clases_adquiridas) <= 0)
                                        <div class="alert alert-danger mt-2">
                                            <small><i class="fas fa-exclamation-triangle"></i> Sin clases disponibles</small>
                                        </div>
                                    @elseif(($membresia->clases_disponibles ?? $membresia->clases_adquiridas) <= 2)
                                        <div class="alert alert-warning mt-2">
                                            <small><i class="fas fa-info-circle"></i> Te quedan pocas clases</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer text-center text-muted bg-light rounded-bottom">
                                    <small><i class="fas fa-calendar-day"></i> Creada: {{ \Carbon\Carbon::parse($membresia->created_at)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($membresias->count() > 1)
                    @php
                        $totalAdquiridas = $membresias->sum('clases_adquiridas');
                        $totalOcupadas = $membresias->sum('clases_ocupadas');
                        $totalDisponibles = $membresias->sum('clases_disponibles');
                    @endphp

                    <div class="card mt-4 border-0 shadow-sm" style="border-radius: 1rem;">
                        <div class="card-header text-white" style="background-color: #00796b; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                            <h5 class="mb-0"><i class="fas fa-chart-line"></i> Resumen General</h5>
                        </div>
                        <div class="card-body text-center bg-white">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="text-info">{{ $membresias->count() }}</h3>
                                    <p>Membresías Activas</p>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="text-primary">{{ $totalAdquiridas }}</h3>
                                    <p>Clases Adquiridas</p>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="text-warning">{{ $totalOcupadas }}</h3>
                                    <p>Clases Ocupadas</p>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="text-success">{{ $totalDisponibles }}</h3>
                                    <p>Clases Disponibles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-swimmer fa-4x text-info mb-4"></i>
                    <h4 class="text-muted">Aún no cuentas con membresías activas</h4>
                    <p class="text-muted">Contáctanos para comenzar a disfrutar de las experiencias acuáticas de <strong>SquashPlash</strong>.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    body {
        background: linear-gradient(to right, #d0f0ff, #ffffff);
    }

    h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: bold;
    }

    .card {
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 0.7rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .progress {
        background-color: #e0f7fa;
        border-radius: 1rem;
    }

    .alert {
        border-radius: 0.75rem;
    }
</style>
@stop

@section('js')
<script>
    console.log("Vista de membresías cargada correctamente en SquashPlash");
</script>
@stop
