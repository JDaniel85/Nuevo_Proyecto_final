@extends('adminlte::page')

@section('title', 'Clases a Impartir')

@section('content_header')
<h1 class="text-primary">
<i class="fas fa-swimmer"></i> Clases de {{ Auth::user()->name }}
</h1>
@stop

@section('content')
<div class="container-fluid">
@if ($clases->isEmpty())
<div class="card shadow-sm border border-info">
<div class="card-body text-center bg-light-blue rounded">
<i class="fas fa-info-circle fa-3x text-info mb-3"></i>
<h4 class="text-info">No tienes clases asignadas aún</h4>
<p class="text-muted">¡Parece que todavía no te han asignado ninguna clase para impartir! Contacta al administrador si crees que esto es un error.</p>

</div>
</div>
@else
<div class="card border-info shadow">
<div class="card-header bg-info text-white d-flex align-items-center">
<i class="fas fa-calendar-alt mr-2"></i>
<h4 class="mb-0">Listado de Clases Asignadas</h4>
</div>
<div class="card-body bg-light">
<table class="table table-bordered table-hover text-center">
<thead class="table-info">
<tr>
<th>ID</th>
<th>Fecha</th>
<th>Profesor</th>
<th>Tipo</th>
<th>Lugares</th>
<th>Ocupados</th>
<th>Disponibles</th>
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
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endif
</div>
@stop

@section('css')

<style> .bg-light-blue { background: linear-gradient(to right, #d0f0fd, #e6faff); } .card { border-radius: 15px; } .table-info th { background-color: #5bc0de !important; color: #fff; } h1 i { margin-right: 10px; } </style>
@stop