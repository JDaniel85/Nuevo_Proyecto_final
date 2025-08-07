@extends('adminlte::page')

@section('title', 'Clases Disponibles | SquashPlash')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-swimming-pool text-info"></i> 
                Clases Disponibles
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Clases Disponibles</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    
    <!-- Alerta de membresías -->
    @if(!$tieneClasesDisponibles)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Sin clases disponibles</h5>
            No tienes clases disponibles en tus membresías. 
            <a href="{{ route('membresias.cliente') }}" class="alert-link">Ver mis membresías</a>
            o contacta con nosotros para adquirir más clases.
        </div>
    @else
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-info-circle"></i> Clases disponibles en tu cuenta</h5>
            Tienes <strong>{{ $totalClasesDisponibles }}</strong> clases disponibles en tus membresías.
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> ¡Éxito!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error</h5>
            {{ session('error') }}
        </div>
    @endif

    @if($clases->count() > 0)
        <div class="row">
            @foreach($clases as $clase)
                @php
                    $yaInscrito = in_array($clase->id, $clasesInscritas);
                    $claseFecha = \Carbon\Carbon::parse($clase->fecha);
                    $esHoy = $claseFecha->isToday();
                    $porcentajeOcupacion = ($clase->lugares_ocupados / $clase->lugares) * 100;
                @endphp
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card clase-card {{ $esHoy ? 'border-warning' : 'border-info' }} card-outline">
                        <div class="card-header {{ $esHoy ? 'bg-warning' : 'bg-info' }} text-white">
                            <h3 class="card-title">
                                <i class="fas fa-swimmer"></i>
                                {{ $clase->tipo }}
                            </h3>
                            <div class="card-tools">
                                @if($esHoy)
                                    <span class="badge badge-light">
                                        <i class="fas fa-star"></i> HOY
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <i class="fas fa-calendar-alt text-info"></i>
                                <strong>Fecha:</strong> {{ $claseFecha->format('d/m/Y H:i') }}
                            </div>
                            
                            <div class="info-item mb-3">
                                <i class="fas fa-user-tie text-info"></i>
                                <strong>Profesor:</strong> {{ $clase->profesor->name ?? 'No asignado' }}
                            </div>

                            <div class="info-item mb-3">
                                <i class="fas fa-clock text-info"></i>
                                <strong>Duración:</strong> {{ $clase->duracion }}
                            </div>

                            <div class="info-item mb-3">
                                <i class="fas fa-layer-group text-info"></i>
                                <strong>Nivel:</strong> {{ $clase->nivel }}
                            </div>

                            <div class="info-item mb-3">
                                <i class="fas fa-venus-mars text-info"></i>
                                <strong>Público:</strong> {{ $clase->publico_dirigido }}
                            </div>
                            
                            <div class="info-item mb-3">
                                <i class="fas fa-users text-info"></i>
                                <strong>Disponibilidad:</strong> 
                                {{ $clase->lugares_disponibles }}/{{ $clase->lugares }} lugares
                                
                                <div class="progress mt-1" style="height: 10px;">
                                    <div class="progress-bar {{ $porcentajeOcupacion >= 80 ? 'bg-danger' : ($porcentajeOcupacion >= 60 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $porcentajeOcupacion }}%">
                                    </div>
                                </div>
                            </div>
                            
                            @if($porcentajeOcupacion >= 90)
                                <div class="alert alert-warning alert-sm p-2">
                                    <small><i class="fas fa-fire"></i> ¡Últimos lugares!</small>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-footer text-center">
                            @if($yaInscrito)
                                <span class="btn btn-success btn-sm disabled">
                                    <i class="fas fa-check"></i> Ya inscrito
                                </span>
                                
                            @else
                                @if($tieneClasesDisponibles && $clase->lugares_disponibles > 0)
                                    <form action="{{ route('cliente.clases.inscribirse', $clase->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-plus"></i> Inscribirse
                                        </button>
                                    </form>
                                @elseif(!$tieneClasesDisponibles)
                                    <button class="btn btn-secondary disabled" disabled>
                                        <i class="fas fa-lock"></i> Sin clases disponibles
                                    </button>
                                @else
                                    <button class="btn btn-danger disabled" disabled>
                                        <i class="fas fa-times"></i> Clase llena
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card card-info">
            <div class="card-body text-center py-5">
                <i class="fas fa-swimming-pool fa-4x text-info mb-4"></i>
                <h4>No hay clases disponibles</h4>
                <p class="text-muted">No hay clases programadas en este momento.</p>
            </div>
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    .clase-card {
        transition: all 0.3s ease;
    }

    .clase-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,123,255,0.3);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-item i {
        width: 20px;
        text-align: center;
    }

    .alert-sm {
        padding: 0.375rem 0.75rem;
        margin-bottom: 0.5rem;
    }

    .progress {
        background-color: rgba(0,123,255,0.1);
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Animación para las tarjetas
        $('.clase-card').each(function(index) {
            $(this).css('opacity', '0').delay(index * 100).animate({'opacity': '1'}, 500);
        });
        
        // Auto-dismiss alerts después de 5 segundos
        $('.alert').delay(5000).fadeOut();
    });
</script>
@stop