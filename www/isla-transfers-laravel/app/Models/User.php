<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'nombre',
        'rol',
        'creado_en',
    ];

    // Oculta el password en arrays/JSON
    protected $hidden = [
        'password',
    ];

    // Relaciones
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }
}
