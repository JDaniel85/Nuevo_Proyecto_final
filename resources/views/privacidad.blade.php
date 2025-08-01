@extends('layouts.app')

@section('title')
    Aviso de Privacidad
@endsection

@section('contenido')
   
    <div class="max-w-md mx-auto p-7 text-justify bg-white rounded shadow mb-65 items-center dark:bg-gray-700 dark:text-white ">
        <h1 class="text-2xl font-bold mb-4">Aviso de Privacidad</h1>
        <p><strong>Responsable del Tratamiento:</strong> Esta aplicación es responsable de resguardar sus datos personales.</p>
                <p><strong>Datos que recabamos:</strong> Nombre, correo electrónico, contraseña y otros datos requeridos por el sistema.</p>
                <p><strong>Finalidades:</strong> Registrar usuarios, autenticar el acceso, ofrecer funcionalidades según el rol y enviar notificaciones del sistema.</p>
                <p><strong>Protección:</strong> Se aplican medidas técnicas y administrativas para resguardar su información.</p>
                <p><strong>Derechos ARCO:</strong> Usted puede acceder, rectificar, cancelar u oponerse al tratamiento de sus datos en cualquier momento.</p>
                <p><strong>Transferencias:</strong> No se comparten sus datos con terceros, salvo requerimiento legal.</p>
                <p><strong>Modificaciones:</strong> Este aviso puede cambiar. Le notificaremos por este medio.</p>
                <p class="mb-0"><strong>Fecha de actualización:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
    
    
@endsection
