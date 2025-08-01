<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class LogsController extends Controller
{
    /**
     * Descargar archivo de logs
     */
    public function descargar()
    {
        // Registrar la acción de descarga
        $this->logDownloadAction();
        
        $file = storage_path('logs/acciones.log');
        
        // Verificar si el archivo existe
        if (!file_exists($file)) {
            // Crear archivo vacío si no existe
            file_put_contents($file, "# Log de Acciones del Sistema\n# Generado el: " . Carbon::now()->format('Y-m-d H:i:s') . "\n\n");
        }
        
        $fileName = 'logs_acciones_' . Carbon::now()->format('Y-m-d_H-i-s') . '.log';
        
        return Response::download($file, $fileName, [
            'Content-Type' => 'text/plain',
        ]);
    }
    
    /**
     * Mostrar logs en pantalla (opcional)
     */
    public function mostrar()
    {
        $file = storage_path('logs/acciones.log');
        $logs = [];
        
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $lines = explode("\n", $content);
            
            // Obtener las últimas 50 líneas
            $logs = array_slice(array_reverse($lines), 0, 50);
        }
        
        return view('logs.mostrar', compact('logs'));
    }
    
    /**
     * Limpiar archivo de logs
     */
    public function limpiar()
    {
        $user = Auth::user();
        
        // Registrar la acción de limpieza antes de limpiar
        $this->logCleanAction();
        
        $file = storage_path('logs/acciones.log');
        
        // Crear nuevo archivo con header
        $header = "# Log de Acciones del Sistema\n";
        $header .= "# Archivo limpiado el: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
        $header .= "# Limpiado por: " . $user->name . " (ID: " . $user->id . ")\n\n";
        
        file_put_contents($file, $header);
        
        return redirect()->back()->with('success', 'Archivo de logs limpiado correctamente');
    }
    
    /**
     * Registrar acción de descarga
     */
    private function logDownloadAction()
    {
        $user = Auth::user();
        
        $logMessage = sprintf(
            "[%s] Usuario: %s (ID: %d, Rol: %s) - Acción: Descargó el archivo de logs",
            Carbon::now()->format('Y-m-d H:i:s'),
            $user->name,
            $user->id,
            $user->rol ?? 'Sin rol'
        );
        
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/acciones.log'),
        ])->info($logMessage);
    }
    
    /**
     * Registrar acción de limpieza
     */
    private function logCleanAction()
    {
        $user = Auth::user();
        
        $logMessage = sprintf(
            "[%s] Usuario: %s (ID: %d, Rol: %s) - Acción: Limpió el archivo de logs",
            Carbon::now()->format('Y-m-d H:i:s'),
            $user->name,
            $user->id,
            $user->rol ?? 'Sin rol'
        );
        
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/acciones.log'),
        ])->info($logMessage);
    }
}