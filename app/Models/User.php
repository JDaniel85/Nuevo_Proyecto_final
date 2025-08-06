<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
{
    static::created(function ($user) {
        Log::info("Rol asignado al crear usuario: {$user->rol}");
    });
}

    public function setRolAttribute($value)
    {
    $this->attributes['rol'] = ucfirst(strtolower($value));
    }

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'id_usuario');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_usuario');
    }

    public function clases()
    {
        return $this->hasMany(Clase::class, 'id_profesor'); // si es que la clase tiene 'id_empleado'
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomResetPassword($token));
    }

    public function clasesInscritas()
    {
    return $this->belongsToMany(Clase::class, 'clase_user')->withTimestamps();
        }

    public function clasesa()
{
    return $this->belongsToMany(Clase::class, 'clase_user', 'user_id', 'clase_id');
}
}
