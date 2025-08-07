<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'clases_adquiridas',
        'clases_ocupadas',
        'clases_disponibles',
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación para ver qué clases se usaron con esta membresía
    public function clasesUsadas()
    {
        return $this->belongsToMany(Clase::class, 'clase_user', 'membresia_id', 'clase_id')
                    ->withPivot('user_id', 'created_at')
                    ->withTimestamps();
    }

    // Scopes útiles
    public function scopeConClasesDisponibles($query)
    {
        return $query->where('clases_disponibles', '>', 0);
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('id_usuario', $userId);
    }

    // Métodos helper
    public function puedeUsarClase()
    {
        return $this->clases_disponibles > 0;
    }

    public function porcentajeUso()
    {
        if ($this->clases_adquiridas == 0) return 0;
        return round(($this->clases_ocupadas / $this->clases_adquiridas) * 100, 1);
    }
}