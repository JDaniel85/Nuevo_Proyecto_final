<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ClasesController;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Membresia;

use Illuminate\Support\Facades\DB;

class ClaseInscripcionController extends Controller
{
    // Listar todas las asignaciones
       public function listarTodasAsignaciones()
    {
        $clasesAsignadas = DB::table('clase_user')
            ->join('users', 'clase_user.user_id', '=', 'users.id')
            ->join('clases', 'clase_user.clase_id', '=', 'clases.id')
            ->leftJoin('membresias', 'clase_user.membresia_id', '=', 'membresias.id') // NUEVO JOIN
            ->select(
                'clase_user.id as asignacion_id',
                'users.id as alumno_id',
                'users.name as alumno_nombre',
                'clases.id as clase_id',
                'clases.tipo as clase_tipo',
                'clases.fecha',
                'membresias.id as membresia_id' // NUEVO CAMPO
            )
            ->orderBy('clase_user.id', 'desc')
            ->get();

        return view('admin.clases_asignadas', compact('clasesAsignadas'));
    }

    // Formulario para crear asignación
    /*public function formAsignarClase()
    {
        // Filtrar solo usuarios con rol "Cliente"
        $usuarios = DB::table('users')->where('rol', 'Cliente')->get();
        $clases = DB::table('clases')
    ->where('fecha', '>=', now())
    ->where('lugares_disponibles', '>', 0)
    ->orderBy('fecha', 'asc')
    ->get();
        return view('admin.asignar_clase', compact('usuarios', 'clases'));
    }*/

    public function formAsignarClase()
    {
        $usuarios = DB::table('users')->where('rol', 'Cliente')->get();
        $clases = DB::table('clases')
            ->where('fecha', '>=', now())
            ->where('lugares_disponibles', '>', 0)
            ->orderBy('fecha', 'asc')
            ->get();
        return view('admin.asignar_clase', compact('usuarios', 'clases'));
    }



    // Guardar nueva asignación
    public function asignarAUsuario(Request $request)
    {
        // Verificar que el usuario tenga clases disponibles
        $usuario = User::find($request->user_id);
        $membresia = Membresia::where('id_usuario', $request->user_id)
                             ->where('clases_disponibles', '>', 0)
                             ->first();

        if (!$membresia) {
            return redirect()->back()->with('error', 'El usuario no tiene clases disponibles en sus membresías.');
        }

        try {
            DB::beginTransaction();

            // Insertar inscripción
            DB::table('clase_user')->insert([
                'user_id' => $request->user_id,
                'clase_id' => $request->clase_id,
                'membresia_id' => $membresia->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Actualizar clase
            $clase = Clase::find($request->clase_id);
            $clase->lugares_ocupados += 1;
            $clase->lugares_disponibles -= 1;
            $clase->save();

            // Actualizar membresía
            $membresia->clases_ocupadas += 1;
            $membresia->clases_disponibles -= 1;
            $membresia->save();

            DB::commit();

            return redirect()->route('admin.clases.listarAsignadas')->with('success', 'Clase asignada correctamente.');
        
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al asignar la clase.');
        }
    }

    // Formulario para editar asignación
public function formEditarAsignacion($id)
    {
        $asignacion = DB::table('clase_user')->where('id', $id)->first();
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
        $inscripcion = DB::table('clase_user')->where('id', $id)->first();
        
        if ($inscripcion) {
            try {
                DB::beginTransaction();

                // Restaurar lugares en la clase
                $clase = Clase::find($inscripcion->clase_id);
                if ($clase) {
                    $clase->lugares_ocupados -= 1;
                    $clase->lugares_disponibles += 1;
                    $clase->save();
                }

                // Restaurar clase en membresía si existe
                if ($inscripcion->membresia_id) {
                    $membresia = Membresia::find($inscripcion->membresia_id);
                    if ($membresia) {
                        $membresia->clases_ocupadas -= 1;
                        $membresia->clases_disponibles += 1;
                        $membresia->save();
                    }
                }

                // Eliminar inscripción
                DB::table('clase_user')->where('id', $id)->delete();

                DB::commit();
                return redirect()->route('admin.clases.listarAsignadas')->with('success', 'Asignación eliminada correctamente.');
                
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Error al eliminar la asignación.');
            }
        }

        return redirect()->back()->with('error', 'Asignación no encontrada.');
    }

    public function mostrarDisponibles()
    {
        $usuario = Auth::user();
        
        if ($usuario->rol !== 'Cliente') {
            abort(403, 'No autorizado');
        }

        // Verificar si el usuario tiene clases disponibles en sus membresías
        $tieneClasesDisponibles = Membresia::where('id_usuario', $usuario->id)
                                          ->where('clases_disponibles', '>', 0)
                                          ->exists();

        // Obtener total de clases disponibles
        $totalClasesDisponibles = Membresia::where('id_usuario', $usuario->id)
                                          ->sum('clases_disponibles');

        $clases = Clase::with('profesor')
            ->where('lugares_disponibles', '>', 0)
            ->where('fecha', '>=', now())
            ->orderBy('fecha', 'asc')
            ->get();

        $clasesInscritas = DB::table('clase_user')
            ->where('user_id', $usuario->id)
            ->pluck('clase_id')
            ->toArray();

        return view('cliente.clases_disponibles', compact('clases', 'clasesInscritas', 'tieneClasesDisponibles', 'totalClasesDisponibles'));
    }


// Mostrar clases del usuario autenticado (para clientes)
public function misClases()
    {
        $usuario = Auth::user();
        
        if ($usuario->rol !== 'Cliente') {
            abort(403, 'No autorizado');
        }

        $clases = DB::table('clase_user')
            ->join('clases', 'clase_user.clase_id', '=', 'clases.id')
            ->join('users', 'clases.id_profesor', '=', 'users.id')
            ->leftJoin('membresias', 'clase_user.membresia_id', '=', 'membresias.id') // NUEVO JOIN
            ->where('clase_user.user_id', '=', $usuario->id)
            ->select(
                'clases.id',
                'clases.fecha',
                'clases.tipo',
                'clases.lugares',
                'clases.lugares_ocupados',
                'clases.lugares_disponibles',
                'clases.duracion',
                'clases.nivel',
                'clases.publico_dirigido',
                'users.name as profesor_nombre',
                'clase_user.created_at as fecha_inscripcion',
                'membresias.id as membresia_id'
            )
            ->orderBy('clases.fecha', 'desc')
            ->get();

        return view('cliente.mis_clases', compact('clases'));
    }


    // Método para que los usuarios se inscriban a una clase
      /**
 * Método mejorado para inscribirse que sincroniza automáticamente
 */
public function inscribirse(Request $request, $claseId)
{
    $usuario = Auth::user();
    
    // Verificaciones básicas
    if ($usuario->rol !== 'Cliente') {
        return redirect()->back()->with('error', 'Solo los clientes pueden inscribirse a clases.');
    }

    $clase = Clase::find($claseId);
    if (!$clase) {
        return redirect()->back()->with('error', 'La clase no existe.');
    }

    if ($clase->lugares_disponibles <= 0) {
        return redirect()->back()->with('error', 'No hay lugares disponibles en esta clase.');
    }

    // Verificar que no esté ya inscrito
    $yaInscrito = DB::table('clase_user')
        ->where('user_id', $usuario->id)
        ->where('clase_id', $claseId)
        ->exists();

    if ($yaInscrito) {
        return redirect()->back()->with('error', 'Ya estás inscrito en esta clase.');
    }

    // ✅ Buscar membresía con clases disponibles (datos sincronizados)
    $membresia = Membresia::where('id_usuario', $usuario->id)
                         ->where('clases_disponibles', '>', 0)
                         ->orderBy('created_at', 'asc')
                         ->first();
    
    if (!$membresia) {
        return redirect()->back()->with('error', 'No tienes clases disponibles en tus membresías. Contacta al administrador.');
    }

    try {
        DB::beginTransaction();

        // 1. ✅ Inscribir CON membresia_id (CRÍTICO)
        DB::table('clase_user')->insert([
            'user_id' => $usuario->id,
            'clase_id' => $claseId,
            'membresia_id' => $membresia->id, // ✅ SIEMPRE se asigna
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Actualizar lugares de la clase
        $clase->decrement('lugares_disponibles');
        $clase->increment('lugares_ocupados');

        // 3. ✅ Actualizar membresía (mantiene sincronización automática)
        $membresia->increment('clases_ocupadas');
        $membresia->decrement('clases_disponibles');

        DB::commit();

        // Recargar datos actualizados
        $membresiaActualizada = $membresia->fresh();
        
        return redirect()->back()->with('success', 
            "Te has inscrito exitosamente a la clase '{$clase->tipo}'. Te quedan {$membresiaActualizada->clases_disponibles} clases en tu membresía."
        );

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Error al inscribirte: ' . $e->getMessage());
    }
}


private function sincronizarMembresia($membresiaId)
{
    $membresia = Membresia::find($membresiaId);
    if (!$membresia) return;
    
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
}


}