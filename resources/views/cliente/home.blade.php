@extends('adminlte::page')

@php
$nombre = Auth::user()->name;
$rol = Auth::user()->rol;
@endphp

@section('title', "Home | $rol")


@section('content_header')
@stop

@section('content')
<div class="welcome-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <div class="container text-center">
        <div class="card glass-effect shadow-lg p-4">
            <div class="card-body">
                <h1 class="display-4 font-weight-bold text-primary mb-3">¡Bienvenido, {{ Auth::user()->name }}!</h1>
                <h2 class="text-info mb-4">Cliente registrado en <strong>Squash<span style="color:#0d6efd">Plash</span></strong></h2>

                <p class="lead text-dark">
                    En <strong>SquashPlash</strong>, estamos emocionados de contar contigo como parte de nuestra familia. 
                    Gracias por depositar tu confianza en nosotros para llevar el diseño, cuidado y mantenimiento de tu alberca al siguiente nivel.
                </p>

                <p class="mt-4 text-secondary">
                    Nos comprometemos a brindarte un servicio de calidad, atención personalizada y experiencias inolvidables.
                    Como cliente registrado, tu bienestar y satisfacción son nuestra prioridad.
                </p>

                <div class="mt-5">
                    <h5 class="text-uppercase text-muted">"La calidad no es un acto, es un hábito."</h5>
                    <p class="font-italic text-muted">– Aristóteles</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #a8e0ff, #70cad1, #ace5ee);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-wrapper {
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            backdrop-filter: blur(5px);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.75);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        }

        h1, h2, p {
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 3rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.2rem;
            }
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Bienvenido a SquashPlash, tu experiencia acuática comienza aquí.");
    </script>
@stop
