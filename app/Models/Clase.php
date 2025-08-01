<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    /** @use HasFactory<\Database\Factories\ClaseFactory> */
    use HasFactory;

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fecha',
        'id_profesor',
        'tipo',
        'lugares',
        'lugares_ocupados',
        'lugares_disponibles',
    ];

    /**
     * Atributos que deben estar ocultos para la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        // No hay campos sensibles que ocultar, pero puedes agregar 'id_profesor' si no quieres exponerlo directamente
    ];

    /**
     * Atributos que deben ser casteados a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'lugares' => 'integer',
            'lugares_ocupados' => 'integer',
            'lugares_disponibles' => 'integer',
        ];
    }

    /**
     * Relación con el modelo User (profesor).
     */
    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor');
    }
}
