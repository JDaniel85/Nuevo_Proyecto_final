<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClasesController extends Controller
{
    /*public function list()
    {
        $rol = Auth::user()->rol;
        $clases = Clase::with('profesor')->get();

        if ($rol === 'Empleado') {
            return view('empleado.clases_impartir', compact('clases'));
        } elseif ($rol === 'Admin') {
            return view('admin.lista', compact('clases'));
        } else {
            abort(403, 'No autorizado');
        }
    }*/

    public function list()
    {
        $rol = Auth::user()->rol;
        $usuario = Auth::user();
        if ($rol === 'Empleado') {
         // Solo sus clases como profesor
        $clases = Clase::with('profesor')
                    ->where('id_profesor', $usuario->id)
                    ->orderBy('fecha', 'desc')
                    ->get();

        return view('empleado.clases_impartir', compact('clases'));
    }

        if ($rol === 'Admin') {
        // Todas las clases
        $clases = Clase::with('profesor')->orderBy('fecha', 'desc')->get();

        return view('admin.lista', compact('clases'));
    }

    abort(403, 'No autorizado');
    }

    public function index()
    {
        $clase = new Clase();
         $profesores = User::where('rol', 'Empleado')
                      ->orderBy('name')
                      ->get();
        return view('admin.nueva', compact('clase', 'profesores'));
    }

    public function edit($id)
    {
        $clase = Clase::findOrFail($id);
         $profesores = User::where('rol', 'Empleado')
                      ->orderBy('name')
                      ->get();
        return view('admin.nueva', compact('clase', 'profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_profesor' => 'required|exists:users,id',
            'tipo' => 'required|string|max:100',
            'lugares' => 'required|integer|min:1',
        ]);

        $clase = $request->id == 0 ? new Clase() : Clase::findOrFail($request->id);
        $fecha  = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->fecha);

        $clase->fecha = $fecha;
        $clase->id_profesor = $request->id_profesor;
        $clase->tipo = $request->tipo;
        $clase->lugares = $request->lugares;

        if ($request->id == 0) {
            $clase->lugares_ocupados = 0;
            $clase->lugares_disponibles = $request->lugares;
        } else {
            $clase->lugares_disponibles = $clase->lugares - $clase->lugares_ocupados;
        }

        $clase->save();

        return redirect()->route('clases');
    }

    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete();

        return redirect()->route('clases');
    }
}

