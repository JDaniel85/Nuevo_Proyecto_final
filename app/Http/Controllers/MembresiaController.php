<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembresiaController extends Controller
{
    // Listar membresías
   public function list()
    {
        $rol = Auth::user()->rol;

        if ($rol === 'Cliente') {
            $usuario = Auth::user();
            
            // Los datos ya están sincronizados en la base de datos
            $membresias = Membresia::where('id_usuario', $usuario->id)
                ->join('users', 'membresias.id_usuario', '=', 'users.id')
                ->select('membresias.*', 'users.name as cliente')
                ->get();

            // Ya no se usa, pero mantenemos para compatibilidad con la vista
            $clasesInscritas = 0;

            return view('cliente.lista_membresias', compact('membresias', 'clasesInscritas'));
            
        } elseif ($rol === 'Admin' || $rol === 'Empleado') {
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
         $usuarios = User::where('rol', 'Cliente')
                      ->orderBy('name')
                      ->get();
        return view('admin.nueva_membresia', compact('membresia', 'usuarios'));
    }

    // Mostrar formulario para editar membresía
    public function edit($id)
    {
        $membresia = Membresia::findOrFail($id);
         $usuarios = User::where('rol', 'Cliente')
                      ->orderBy('name')
                      ->get();
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

    public function contarClasesInscritas($usuarioId)
{
    return DB::table('clase_user')
        ->where('user_id', $usuarioId)
        ->count();
}

public function sincronizarMembresia($membresiaId)
{
    $membresia = Membresia::findOrFail($membresiaId);
    
    // Contar clases ocupadas de esta membresía específica
    $clasesOcupadas = DB::table('clase_user')
        ->where('membresia_id', $membresiaId)
        ->count();
    
    // Calcular clases disponibles
    $clasesDisponibles = max($membresia->clases_adquiridas - $clasesOcupadas, 0);
    
    // Actualizar en la base de datos
    $membresia->update([
        'clases_ocupadas' => $clasesOcupadas,
        'clases_disponibles' => $clasesDisponibles
    ]);
    
    return $membresia;
}

public function sincronizarMembresiasUsuario($usuarioId)
{
    $membresias = Membresia::where('id_usuario', $usuarioId)->get();
    
    foreach ($membresias as $membresia) {
        $this->sincronizarMembresia($membresia->id);
    }
    
    return $membresias->fresh(); // Recargar datos actualizados
}
    
}
