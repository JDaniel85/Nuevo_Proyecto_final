@extends('adminlte::page')

@section('title', 'Logs del Sistema')

@section('content_header')
    <h1>Logs del Sistema</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i> Registro de Actividades
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('logs.descargar') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Descargar Logs
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        @if(count($logs) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Hora</th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Acción</th>
                                            <th>Ruta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $log)
                                            @if(trim($log) && !str_starts_with($log, '#'))
                                                @php
                                                    // Extraer información del log
                                                    preg_match('/\[(.*?)\].*?Usuario: (.*?) \(ID: (\d+), Rol: (.*?)\) - Acción: (.*?) - Ruta: (.*?) - Método: (.*)/', $log, $matches);
                                                    
                                                    if(count($matches) >= 7) {
                                                        $timestamp = $matches[1];
                                                        $userName = $matches[2];
                                                        $userId = $matches[3];
                                                        $userRole = $matches[4];
                                                        $action = $matches[5];
                                                        $route = $matches[6];
                                                        $method = $matches[7];
                                                    } else {
                                                        // Formato alternativo para login/logout
                                                        preg_match('/\[(.*?)\].*?Usuario: (.*?) \(ID: (\d+), Rol: (.*?)\) - Acción: (.*)/', $log, $altMatches);
                                                        if(count($altMatches) >= 5) {
                                                            $timestamp = $altMatches[1];
                                                            $userName = $altMatches[2];
                                                            $userId = $altMatches[3];
                                                            $userRole = $altMatches[4];
                                                            $action = $altMatches[5];
                                                            $route = '-';
                                                            $method = '-';
                                                        }
                                                    }
                                                @endphp
                                                
                                                @if(isset($timestamp))
                                                    <tr>
                                                        <td>
                                                            <small class="text-muted">{{ $timestamp }}</small>
                                                        </td>
                                                        <td>
                                                            <strong>{{ $userName }}</strong>
                                                            <br><small class="text-muted">ID: {{ $userId }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $userRole == 'Admin' ? 'danger' : ($userRole == 'Empleado' ? 'warning' : 'info') }}">
                                                                {{ $userRole }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $action }}</td>
                                                        <td>
                                                            <code>{{ $route }}</code>
                                                            @if(isset($method) && $method != '-')
                                                                <span class="badge badge-secondary">{{ $method }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Sin registros</h5>
                                No hay logs de actividad disponibles.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        .card-tools .btn {
            margin-left: 5px;
        }
        code {
            font-size: 0.85em;
        }
    </style>
@stop

@section('js')
    <script>
        // Auto-refresh cada 30 segundos
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
@stop