@extends('adminlte::page')

@section('title', 'Mis Clases')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-swimming-pool text-info"></i> 
                Mis Clases
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Mis Clases</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info swimming-card">
                <div class="inner">
                    <h3>{{ $clases->count() }}</h3>
                    <p>Total de Clases</p>
                </div>
                <div class="icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="small-box-footer">
                    <span class="olympic-ring ring-blue"></span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success swimming-card">
                <div class="inner">
                    <h3>{{ $clases->where('fecha', '>=', now())->count() }}</h3>
                    <p>Próximas Clases</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="small-box-footer">
                    <span class="olympic-ring ring-green"></span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary swimming-card">
                <div class="inner">
                    <h3>{{ $clases->where('fecha', '<', now())->count() }}</h3>
                    <p>Clases Pasadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="small-box-footer">
                    <span class="olympic-ring ring-black"></span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning swimming-card">
                <div class="inner">
                    <h3>{{ $clases->where('fecha', '>=', now()->startOfDay())->where('fecha', '<=', now()->endOfDay())->count() }}</h3>
                    <p>Clases Hoy</p>
                </div>
                <div class="icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <div class="small-box-footer">
                    <span class="olympic-ring ring-yellow"></span>
                </div>
            </div>
        </div>
    </div>

    @if($clases->count() > 0)
        <!-- Lista de Clases -->
        <div class="row">
            @foreach($clases as $clase)
                @php
                    $now = now();
                    $claseFecha = \Carbon\Carbon::parse($clase->fecha);
                    $isToday = $claseFecha->isToday();
                    $isPast = $claseFecha->isPast();
                @endphp
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card class-card {{ $isToday ? 'card-warning' : ($isPast ? 'card-secondary' : 'card-info') }} card-outline">
                        <div class="card-header aqua-header">
                            <h3 class="card-title">
                                <i class="fas fa-swimmer"></i>
                                {{ $clase->tipo }}
                            </h3>
                            <div class="card-tools">
                                @if($isToday)
                                    <span class="badge badge-warning animated-badge">
                                        <i class="fas fa-star"></i> HOY
                                    </span>
                                @elseif($isPast)
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-history"></i> PASADA
                                    </span>
                                @else
                                    <span class="badge badge-info">
                                        <i class="fas fa-clock"></i> PRÓXIMA
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="info-item mb-2">
                                <i class="fas fa-calendar-alt text-info"></i>
                                <strong>Fecha:</strong> {{ $claseFecha->format('d/m/Y H:i') }}
                            </div>
                            
                            <div class="info-item mb-2">
                                <i class="fas fa-user-tie text-info"></i>
                                <strong>Instructor:</strong>
                            </div>
                            <div class="instructor-card mb-3">
                                <i class="fas fa-medal text-warning"></i>
                                <strong>{{ $clase->profesor_nombre }}</strong>
                            </div>
                            
                            <div class="info-item mb-2">
                                <i class="fas fa-users text-info"></i>
                                <strong>Lugares:</strong> {{ $clase->lugares_ocupados }}/{{ $clase->lugares }}
                                <div class="progress mt-1" style="height: 8px;">
                                    <div class="progress-bar bg-info" 
                                         style="width: {{ ($clase->lugares_ocupados / $clase->lugares) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-calendar-plus text-info"></i>
                                <strong>Inscrito:</strong> {{ \Carbon\Carbon::parse($clase->fecha_inscripcion)->format('d/m/Y') }}
                            </div>
                        </div>
                        
                        <div class="card-footer aqua-footer">
                            <div class="wave-effect"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado vacío -->
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-body text-center empty-state">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-swimming-pool"></i>
                        </div>
                        <h3>¡Aún no tienes clases!</h3>
                        <p class="lead">Es hora de sumergirte en el mundo de la natación.</p>
                        <a href="{{ route('clases.disponibles') }}" class="btn btn-info btn-lg mt-3">
                            <i class="fas fa-search"></i> Explorar Clases Disponibles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    /* Tema Acuático para AdminLTE */
    .swimming-card {
        position: relative;
        overflow: hidden;
    }
    
    .swimming-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><path d="M0,10 Q25,5 50,10 T100,10" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/></svg>') repeat-x;
        pointer-events: none;
    }
    
    .olympic-ring {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid;
        border-radius: 50%;
        margin-left: 10px;
    }
    
    .ring-blue { border-color: #0085c7; }
    .ring-yellow { border-color: #f4c430; }
    .ring-black { border-color: #000000; }
    .ring-green { border-color: #009f3d; }
    .ring-red { border-color: #df0024; }
    
    .class-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
    }
    
    .aqua-header {
        position: relative;
        background: linear-gradient(135deg, #17a2b8, #007bff);
        color: white;
        border: none;
    }
    
    .aqua-footer {
        position: relative;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        height: 10px;
        border: none;
    }
    
    .wave-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><path d="M0,10 Q25,5 50,10 T100,10 V20 H0 Z" fill="rgba(23,162,184,0.3)"/></svg>') repeat-x;
        animation: wave 3s ease-in-out infinite;
    }
    
    @keyframes wave {
        0%, 100% { transform: translateX(-25px); }
        50% { transform: translateX(25px); }
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
    
    .instructor-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 8px;
        padding: 10px;
        border-left: 4px solid #17a2b8;
        margin-left: 30px;
    }
    
    .animated-badge {
        animation: glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes glow {
        from { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
        to { box-shadow: 0 0 15px rgba(255, 193, 7, 0.8); }
    }
    
    .empty-state {
        padding: 60px 20px;
    }
    
    .empty-icon i {
        font-size: 5rem;
        color: #17a2b8;
        opacity: 0.7;
    }
    
    .progress {
        background-color: rgba(23, 162, 184, 0.2);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .col-lg-3 {
            margin-bottom: 15px;
        }
        
        .class-card {
            margin-bottom: 20px;
        }
    }
    
    /* Efectos de hover mejorados */
    .small-box:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
    }
    
    .card-outline.card-info:hover {
        border-color: #17a2b8;
        box-shadow: 0 0 20px rgba(23, 162, 184, 0.3);
    }
    
    .card-outline.card-warning:hover {
        border-color: #ffc107;
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Animación de entrada para las tarjetas
        $('.class-card').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(30px)'
            }).delay(index * 100).animate({
                'opacity': '1'
            }, 500).css('transform', 'translateY(0)');
        });
        
        // Efecto de pulso para estadísticas
        $('.small-box').hover(
            function() {
                $(this).find('.olympic-ring').addClass('animate__pulse');
            },
            function() {
                $(this).find('.olympic-ring').removeClass('animate__pulse');
            }
        );
        
        // Toast para clases de hoy
        @if($clases->where('fecha', '>=', now()->startOfDay())->where('fecha', '<=', now()->endOfDay())->count() > 0)
            toastr.info('¡Tienes {{ $clases->where("fecha", ">=", now()->startOfDay())->where("fecha", "<=", now()->endOfDay())->count() }} clase(s) hoy!', 'Recordatorio');
        @endif
    });
</script>
@stop