@extends('adminlte::page')

@section('title', 'Mis Membresías')

@section('content_header')
    <h1>Mis Membresías</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h4>Estado de mis Membresías</h4>
        </div>
        <div class="card-body bg-light">
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
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-dumbbell"></i> Membresía #{{ $membresia->id }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="border-right">
                                            <h4 class="text-primary">{{ $membresia->clases_adquiridas }}</h4>
                                            <small class="text-muted">Adquiridas</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border-right">
                                            <h4 class="text-warning">{{ $membresia->clases_ocupadas ?? 0 }}</h4>
                                            <small class="text-muted">Ocupadas</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-success">{{ $membresia->clases_disponibles ?? $membresia->clases_adquiridas }}</h4>
                                        <small class="text-muted">Disponibles</small>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <!-- Barra de progreso -->
                                @php
                                    $porcentaje = $membresia->clases_adquiridas > 0 
                                        ? (($membresia->clases_ocupadas ?? 0) / $membresia->clases_adquiridas) * 100 
                                        : 0;
                                @endphp
                                
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-warning" 
                                         role="progressbar" 
                                         style="width: {{ $porcentaje }}%" 
                                         aria-valuenow="{{ $porcentaje }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ number_format($porcentaje, 1) }}%
                                    </div>
                                </div>
                                
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Has usado {{ $membresia->clases_ocupadas ?? 0 }} de {{ $membresia->clases_adquiridas }} clases
                                </small>
                                
                                @if(($membresia->clases_disponibles ?? $membresia->clases_adquiridas) <= 0)
                                    <div class="alert alert-warning mt-2 mb-0">
                                        <small><i class="fas fa-exclamation-triangle"></i> No tienes clases disponibles</small>
                                    </div>
                                @elseif(($membresia->clases_disponibles ?? $membresia->clases_adquiridas) <= 2)
                                    <div class="alert alert-info mt-2 mb-0">
                                        <small><i class="fas fa-info-circle"></i> Te quedan pocas clases disponibles</small>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer text-muted text-center">
                                <small>
                                    <i class="fas fa-calendar"></i> 
                                    Creada: {{ \Carbon\Carbon::parse($membresia->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Resumen general -->
                @php
                    $totalAdquiridas = $membresias->sum('clases_adquiridas');
                    $totalOcupadas = $membresias->sum('clases_ocupadas');
                    $totalDisponibles = $membresias->sum('clases_disponibles');
                @endphp
                
                @if($membresias->count() > 1)
                <div class="card border-primary mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Resumen General</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h3 class="text-info">{{ $membresias->count() }}</h3>
                                <p class="text-muted">Membresías Activas</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-primary">{{ $totalAdquiridas }}</h3>
                                <p class="text-muted">Total Adquiridas</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-warning">{{ $totalOcupadas }}</h3>
                                <p class="text-muted">Total Ocupadas</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-success">{{ $totalDisponibles }}</h3>
                                <p class="text-muted">Total Disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-dumbbell fa-5x text-muted"></i>
                    </div>
                    <h4 class="text-muted">No tienes membresías activas</h4>
                    <p class="text-muted">Contacta al administrador para adquirir una membresía y comenzar a entrenar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .border-right {
        border-right: 1px solid #dee2e6;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.15s ease-in-out;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@stop