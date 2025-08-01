<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembresiaController extends Controller
{
    // Listar membresías
    public function list()
{
    $rol = Auth::user()->rol;

    if ($rol === 'Cliente') {
        // Los clientes solo ven SUS membresías
        $membresias = Membresia::where('id_usuario', Auth::id())
            ->join('users', 'membresias.id_usuario', '=', 'users.id')
            ->select('membresias.*', 'users.name as cliente')
            ->get();
        return view('cliente.lista_membresias', compact('membresias'));
    } elseif ($rol === 'Admin' || $rol === 'Empleado') {
        // Admin y Empleado ven TODAS las membresías
        $membresias = Membresia::join('users', 'membresias.id_usuario', '=', 'users.id')
            ->select('membresias.*', 'users.name as cliente')
            ->get();
        return view('admin.lista_membresias', compact('membresias'));
    } else {
        abort(403, 'No autorizado');
    }
}

    // Mostrar formulario para nueva membresía
    public function create()
    {
        $membresia = new Membresia();
        $usuarios = User::all();
        return view('admin.nueva_membresia', compact('membresia', 'usuarios'));
    }

    // Mostrar formulario para editar membresía
    public function edit($id)
    {
        $membresia = Membresia::findOrFail($id);
        $usuarios = User::all();
        return view('admin.nueva_membresia', compact('membresia', 'usuarios'));
    }

    // Guardar membresía (nuevo o editar)
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'clases_adquiridas' => 'required|integer|min:1',
            'clases_ocupadas' => 'nullable|integer|min:0',
            'clases_disponibles' => 'nullable|integer|min:0',
        ]);

        $membresia = $request->id == 0 ? new Membresia() : Membresia::findOrFail($request->id);

        $membresia->id_usuario = $request->id_usuario;
        $membresia->clases_adquiridas = $request->clases_adquiridas;

        if ($request->id == 0) {
            $membresia->clases_ocupadas = 0;
            $membresia->clases_disponibles = $request->clases_adquiridas;
        } else {
            $membresia->clases_ocupadas = $request->clases_ocupadas ?? $membresia->clases_ocupadas;
            $membresia->clases_disponibles = $request->clases_disponibles ?? ($membresia->clases_adquiridas - $membresia->clases_ocupadas);
        }

        $membresia->save();

        return redirect()->route('membresias.lista')->with('success', 'Membresía guardada correctamente.');
    }

    // Eliminar membresía
    public function destroy($id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->delete();
        return redirect()->route('membresias.lista')->with('success', 'Membresía eliminada correctamente.');
    }
}
