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
                        @php
                            // AHORA USAMOS LOS DATOS SINCRONIZADOS DE LA BASE DE DATOS
                            $clasesOcupadas = $membresia->clases_ocupadas;
                            $clasesDisponibles = $membresia->clases_disponibles;
                            $clasesAdquiridas = $membresia->clases_adquiridas;
                            $porcentaje = $clasesAdquiridas > 0 
                                ? ($clasesOcupadas / $clasesAdquiridas) * 100 
                                : 0;
                        @endphp

                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                                <div class="card-header text-white" style="background-color: #00bcd4; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    <h5 class="mb-0"><i class="fas fa-water"></i> Membresía</h5>
                                </div>
                                <div class="card-body bg-white">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h4 class="text-primary">{{ $clasesAdquiridas }}</h4>
                                            <small class="text-muted">Clases Adquiridas</small>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="text-warning">{{ $clasesOcupadas }}</h4>
                                            <small class="text-muted">Clases Ocupadas</small>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="text-success">{{ $clasesDisponibles }}</h4>
                                            <small class="text-muted">Clases Disponibles</small>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="progress mb-2" style="height: 18px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $porcentaje }}%">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>

                                    <small class="text-muted"><i class="fas fa-info-circle"></i> Usadas: {{ $clasesOcupadas }} de {{ $clasesAdquiridas }}</small>

                                    @if($clasesDisponibles <= 0)
                                        <div class="alert alert-danger mt-2 text-center fw-bold">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            <strong>¡Atención!</strong> No tienes clases disponibles. Contacta al administrador para renovar tu membresía.
                                        </div>
                                    @elseif($clasesDisponibles <= 2)
                                        <div class="alert alert-warning mt-2 text-center fw-bold">
                                            <i class="fas fa-info-circle"></i> 
                                            <strong>¡Aviso!</strong> Te quedan solo {{ $clasesDisponibles }} clases disponibles. ¡Aprovecha y renueva pronto!
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
                        // DATOS SINCRONIZADOS PARA EL RESUMEN GENERAL
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
                                    <p>Total Clases Adquiridas</p>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="text-warning">{{ $totalOcupadas }}</h3>
                                    <p>Total Clases Ocupadas</p>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="text-success">{{ $totalDisponibles }}</h3>
                                    <p>Total Clases Disponibles</p>
                                </div>
                            </div>

                            @if($totalDisponibles <= 0)
                                <div class="alert alert-danger mt-3 text-center fw-bold">
                                    <i class="fas fa-exclamation-triangle"></i> No tienes clases disponibles en ninguna membresía.
                                </div>
                            @elseif($totalDisponibles <= 2)
                                <div class="alert alert-warning mt-3 text-center fw-bold">
                                    <i class="fas fa-info-circle"></i> Te quedan pocas clases disponibles en total.
                                </div>
                            @endif
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
    console.log("Vista de membresías cargada correctamente en SquashPlash - Datos sincronizados");
</script>
@stop