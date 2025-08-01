<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Clase;
use App\Models\Pago;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rol = Auth::user()->rol;

        switch ($rol) {
            case 'Admin':
                $totalClientes = User::where('rol', 'Cliente')->count();
                $totalEmpleados = User::where('rol', 'Empleado')->count();
                $clasesHoy = Clase::whereDate('fecha', now())->count();
                $ingresosMes = Pago::whereMonth('fecha', now()->month)->sum('monto');

                // Alertas Dinámicas
                $alertas = [];

                 // Clientes que NO tienen pago este mes
                $clientesSinPago = User::where('rol', 'Cliente')
                    ->whereDoesntHave('pagos', function($q) {
                        $q->whereMonth('fecha', now()->month);
                    })->get();

                foreach ($clientesSinPago as $cliente) {
                    $alertas[] = "El cliente {$cliente->name} no ha pagado su mensualidad.";
                }

                // Empleados sin clases hoy
                $empleadosSinClase = User::where('rol', 'Empleado')
                    ->whereDoesntHave('clases', function($q) {
                        $q->whereDate('fecha', now());
                    })->get();

                foreach ($empleadosSinClase as $empleado) {
                    $alertas[] = "El empleado {$empleado->name} no tiene clases asignadas hoy.";
                }


                return view('admin.home', compact('totalClientes', 'totalEmpleados', 'clasesHoy', 'ingresosMes', 'alertas'));

            case 'Empleado':
                return view('empleado.home');

            case 'Cliente':
            default:
                return view('cliente.home');
        }
    }
}
