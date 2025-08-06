@extends('adminlte::page')

@section('title', 'Clases disponibles')

@section('content_header')
    <h1>Clases disponibles</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($clases as $clase)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong>{{ $clase->tipo }}</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Fecha:</strong> {{ $clase->fecha }}</p>
                        <p><strong>Profesor:</strong> {{ $clase->profesor->name }}</p>
                        <p><strong>Lugares disponibles:</strong> {{ $clase->lugares_disponibles }}</p>
                        <form action="{{ route('cliente.clases.inscribirse', $clase->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary" {{ $clase->lugares_disponibles <= 0 ? 'disabled' : '' }}>
                                Inscribirse
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
