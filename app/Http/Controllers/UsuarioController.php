<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function list()
    {
        $usuarios = User::all();
        return view('admin.lista_usuarios', compact('usuarios'));
    }

    public function index()
    {
        $usuario = new User();  // Nuevo usuario
        return view('admin.nuevo_usuario', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);  // Usuario existente
        return view('admin.nuevo_usuario', compact('usuario'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'rol' => 'required|string|max:50',
            'password' => $request->id ? 'nullable|confirmed|min:6' : 'required|confirmed|min:6',
        ]);

        $usuario = $request->id == 0 ? new User() : User::findOrFail($request->id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios')->with('success', 'Usuario guardado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->membresias()->count() > 0) {
            return redirect()->back()->with('error', 'No puedes eliminar un usuario con membresías activas.');
        }

        $usuario->delete();
        return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente.');
    }
}
