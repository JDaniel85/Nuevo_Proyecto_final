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
                return redirect()->route('admin.home');
            case 'Empleado':
                return redirect()->route('empleado.home');
            case 'Cliente':
            default:
                return redirect()->route('cliente.home');
        }
    }
}
