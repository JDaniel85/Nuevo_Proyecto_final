<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Solo registrar si el usuario está autenticado
        if (Auth::check()) {
            $this->logActivity($request);
        }
        
        return $response;
    }
    
    private function logActivity(Request $request)
    {
        $user = Auth::user();
        $action = $this->getActionDescription($request);
        
        $logData = [
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->rol ?? 'Sin rol',
            'action' => $action,
            'route' => $request->route()->getName() ?? 'Sin nombre',
            'method' => $request->method(),
        ];
        
        $logMessage = sprintf(
            "[%s] Usuario: %s (ID: %d, Rol: %s) - Acción: %s - Ruta: %s - Método: %s",
            $logData['timestamp'],
            $logData['user_name'],
            $logData['user_id'],
            $logData['user_role'],
            $logData['action'],
            $logData['route'],
            $logData['method']
        );
        
        // Escribir en el archivo de log personalizado
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/acciones.log'),
        ])->info($logMessage);
    }
    
    private function getActionDescription(Request $request): string
    {
        $routeName = $request->route()->getName();
        $method = $request->method();
        
        // Mapeo de rutas a descripciones amigables
        $actions = [
            'home' => 'Accedió al dashboard principal',
            'membresias' => 'Visitó la lista de membresías',
            'membresias.nueva' => 'Accedió al formulario de nueva membresía',
            'membresia.guardar' => $method === 'POST' ? 'Guardó una membresía' : 'Procesó formulario de membresía',
            'membresia.editar' => 'Accedió al formulario de edición de membresía',
            'membresia.eliminar' => 'Eliminó una membresía',
            
            'usuarios' => 'Visitó la lista de usuarios',
            'usuarios.nuevo' => 'Accedió al formulario de nuevo usuario',
            'usuarios.guardar' => $method === 'POST' ? 'Guardó un usuario' : 'Procesó formulario de usuario',
            'usuarios.editar' => 'Accedió al formulario de edición de usuario',
            'usuarios.eliminar' => 'Eliminó un usuario',
            
            'clases' => 'Visitó la lista de clases',
            'clase.nueva' => 'Accedió al formulario de nueva clase',
            'clase.guardar' => $method === 'POST' ? 'Guardó una clase' : 'Procesó formulario de clase',
            'clase.editar' => 'Accedió al formulario de edición de clase',
            'clase.eliminar' => 'Eliminó una clase',
            
            'registro' => 'Visitó la sección de registros/eventos',
            'logs.descargar' => 'Descargó el archivo de logs',
        ];
        
        return $actions[$routeName] ?? "Accedió a: " . ($routeName ?? $request->path());
    }
}