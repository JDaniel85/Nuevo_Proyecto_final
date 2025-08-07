<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $inactivityLimit = config('session.lifetime') * 60; // Convertir a segundos
            $lastActivity = Session::get('last_activity', time());
            
            if (time() - $lastActivity > $inactivityLimit) {
                Auth::logout();
                Session::flush();
                Session::regenerate();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Sesión cerrada por inactividad',
                        'redirect' => route('login')
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('warning', 'Tu sesión ha expirado por inactividad');
            }
            
            // Actualizar última actividad
            Session::put('last_activity', time());
        }
        
        return $next($request);
    }
}