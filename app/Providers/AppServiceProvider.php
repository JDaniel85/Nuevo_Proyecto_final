<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerificaRol;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('ver-menu-clases', function($user) {
            return in_array($user->rol, ['Admin', 'Empleado']);
        });
        Gate::define('es-admin', function($user){
            return $user->rol === "Admin";
        });

        Gate::define('es-cliente', function($user){
            return $user->rol === "Cliente";
        });

        Gate::define('es-instructor', function($user){
            return $user->rol === "Empleado";
        });
        

        Route::aliasMiddleware('rol',VerificaRol::class);
    }
}
