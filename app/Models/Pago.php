<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos'; // opcional, Laravel ya lo deduce

    protected $fillable = [
        'id_usuario',
        'id_membresia',
        'id_clase',
        'monto',
        'fecha',
    ];

    // Relación: Pago pertenece a un Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación: Pago pertenece a una Membresia
    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'id_membresia');
    }

    // Relación: Pago pertenece a una Clase
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }
}
