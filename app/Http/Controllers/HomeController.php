<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
                return view('admin.home');
            case 'Empleado':
                return view('empleado.home');
            case 'Cliente':
            default:
                return view('cliente.home');
        }
    }
}
