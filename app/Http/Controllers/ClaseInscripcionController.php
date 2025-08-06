<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ClasesController;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class ClaseInscripcionController extends Controller
{
    // Listar todas las asignaciones
    public function listarTodasAsignaciones()
    {
        $clasesAsignadas = DB::table('clase_user')
            ->join('users', 'clase_user.user_id', '=', 'users.id')
            ->join('clases', 'clase_user.clase_id', '=', 'clases.id')
            ->select(
                'clase_user.id as asignacion_id',
                'users.id as alumno_id',
                'users.name as alumno_nombre',
                'clases.id as clase_id',
                'clases.tipo as clase_tipo'
            )
            ->orderBy('clase_user.id')
            ->get();

        return view('admin.clases_asignadas', compact('clasesAsignadas'));
    }

    // Formulario para crear asignación
    public function formAsignarClase()
    {
        // Filtrar solo usuarios con rol "Cliente"
        $usuarios = DB::table('users')->where('rol', 'Cliente')->get();
        $clases = DB::table('clases')->get();
        return view('admin.asignar_clase', compact('usuarios', 'clases'));
    }

    // Guardar nueva asignación
    public function asignarAUsuario(Request $request)
    {
        DB::table('clase_user')->insert([
            'user_id' => $request->user_id,
            'clase_id' => $request->clase_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.clases.listarAsignadas')->with('success', 'Clase asignada correctamente.');
    }

    // Formulario para editar asignación
    public function formEditarAsignacion($id)
    {
        $asignacion = DB::table('clase_user')->where('id', $id)->first();
        
        // Filtrar solo usuarios con rol "Cliente"
        $usuarios = DB::table('users')->where('rol', 'Cliente')->get();
        $clases = DB::table('clases')->get();

        return view('admin.asignar_clase', compact('usuarios', 'clases', 'asignacion'));
    }

    // Guardar cambios de edición
    public function editarAsignacion(Request $request, $id)
    {
        DB::table('clase_user')->where('id', $id)->update([
            'user_id' => $request->user_id,
            'clase_id' => $request->clase_id,
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.clases.listarAsignadas')->with('success', 'Asignación actualizada correctamente.');
    }

    // Eliminar asignación
    public function eliminarAsignacion($id)
    {
        DB::table('clase_user')->where('id', $id)->delete();
        return redirect()->route('admin.clases.listarAsignadas')->with('success', 'Asignación eliminada correctamente.');
    }


// Mostrar clases del usuario autenticado (para clientes)
public function misClases()
{
    $usuario = Auth::user();
    
    if ($usuario->rol !== 'Cliente') {
        abort(403, 'No autorizado');
    }

    // Obtener solo las clases en las que está inscrito el usuario autenticado
    $clases = DB::table('clase_user')
        ->join('clases', 'clase_user.clase_id', '=', 'clases.id')
        ->join('users', 'clases.id_profesor', '=', 'users.id')
        ->where('clase_user.user_id', '=', $usuario->id) // FILTRO ESPECÍFICO CON OPERADOR EXPLÍCITO
        ->select(
            'clases.id',
            'clases.fecha',
            'clases.tipo',
            'clases.lugares',
            'clases.lugares_ocupados',
            'clases.lugares_disponibles',
            'users.name as profesor_nombre',
            'clase_user.created_at as fecha_inscripcion'
        )
        ->orderBy('clases.fecha', 'desc')
        ->get();

    // Debug para verificar el filtro (eliminar en producción)
    // dd($usuario->id, $clases);

    return view('cliente.mis_clases', compact('clases'));
}


    // Método para que los usuarios se inscriban a una clase
    public function inscribirse(Request $request, $claseId)
    {
        $usuario = Auth::user();
        
        // Verificar que el usuario sea cliente
        if ($usuario->rol !== 'Cliente') {
            return redirect()->back()->with('error', 'Solo los clientes pueden inscribirse a clases.');
        }

        // Verificar que la clase existe
        $clase = Clase::find($claseId);
        if (!$clase) {
            return redirect()->back()->with('error', 'La clase no existe.');
        }

        // Verificar que hay lugares disponibles
        if ($clase->lugares_disponibles <= 0) {
            return redirect()->back()->with('error', 'No hay lugares disponibles en esta clase.');
        }

        // Verificar que el usuario no esté ya inscrito
        $yaInscrito = DB::table('clase_user')
            ->where('user_id', $usuario->id)
            ->where('clase_id', $claseId)
            ->exists();

        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta clase.');
        }

        // Inscribir al usuario
        DB::table('clase_user')->insert([
            'user_id' => $usuario->id,
            'clase_id' => $claseId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Actualizar lugares ocupados y disponibles
        $clase->lugares_ocupados += 1;
        $clase->lugares_disponibles -= 1;
        $clase->save();

        return redirect()->back()->with('success', 'Te has inscrito exitosamente a la clase.');
    }

}