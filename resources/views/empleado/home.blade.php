@extends('adminlte::page')

@php
$nombre = Auth::user()->name;
$rol = Auth::user()->rol;
@endphp

@section('title', "Inicio | $rol")

@section('content_header')
{{-- No se necesita encabezado, la portada lo incluye --}}
@stop

@section('content')
                <div class="brand-header text-center my-4">
<h1 class="brand-title display-3">
<span class="text-primary font-weight-bold">Squash</span><span class="text-info font-weight-light">Plash</span>
</h1>
<p class="brand-subtitle text-secondary">Centro de Enseñanza Acuática</p>
</div>
<div class="instructor-dashboard"> <div class="hero-section text-white text-center"> <div class="overlay"> <h1 class="display-1 font-weight-bold" style="font-size: 3rem;">¡Bienvenido, {{ Auth::user()->name }}!</h1> <p class="lead">En SquashPlash valoramos tu dedicación a enseñar y transformar vidas a través de la natación</p> </div> </div>

<div class="container mt-1  ">
    <div class="row g-1">
        <div class="col-md-6">
            <div class="card info-card shadow border-0 bg-water">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-user-tie mr-2"></i>Tu Rol como Instructor</h4>
                    <p class="card-text">
                        Como parte del equipo SquashPlash, eres guía, motivación y ejemplo para nuestros nadadores. Tu trabajo ayuda a desarrollar disciplina, confianza y habilidades acuáticas esenciales.
                    </p>
                    <ul class="list-unstyled pl-3">
                        <li>✔ Impartes clases con pasión y técnica.</li>
                        <li>✔ Eres responsable del bienestar y seguridad del grupo.</li>
                        <li>✔ Fomentas un ambiente positivo y de aprendizaje continuo.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card info-card shadow border-0 bg-info text-white">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-water mr-2"></i>Natación: Más que un deporte</h4>
                    <p class="card-text">
                        La natación es una habilidad de vida. Enseñar a nadar es empoderar a una persona con confianza, salud y resiliencia. ¡Gracias por contribuir al bienestar físico y emocional de nuestros alumnos!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card bg-light shadow border-info">
                <div class="card-body text-center">
                    <h4 class="card-title text-primary"><i class="fas fa-swimmer"></i> Filosofía SquashPlash</h4>
                    <p class="card-text">
                        En nuestra empresa de albercas y enseñanza, creemos en el poder del agua como herramienta de transformación. Nuestros instructores son el corazón del aprendizaje acuático. Su energía, responsabilidad y alegría crean experiencias inolvidables para cada estudiante.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div> @stop
@section('css')
<style>
body {
background: linear-gradient(to bottom, #eaf6fc, #ffffff);
}
    .instructor-dashboard {
        min-height: 100vh;
    }

    .hero-section {
        background: url('{{ asset("images/pool-hero.jpg") }}') no-repeat center center/cover;
        height: 50vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-section .overlay {
        background-color: rgba(0, 90, 140, 0.6);
        padding: 2rem;
        width: 100%;
    }

    .bg-water {
        background: linear-gradient(to bottom right, #a2dfff, #d0f2ff);
    }

    .info-card {
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-weight: 600;
    }
</style>
@stop

@section('js')
<script>
console.log("Inicio de sesión de empleado activo en SquashPlash 🏊‍♂️");
</script>
@stop