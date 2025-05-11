<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferViajero extends Authenticatable
{
    use HasFactory;

    // Configuración exacta de la tabla
    protected $table = 'transfer_viajeros';
    protected $primaryKey = 'id_viajero';
    public $incrementing = true; // Auto-incremental
    public $timestamps = false; // Sin timestamps (created_at/updated_at)

    // Columnas fillable (asignables masivamente)
    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'direccion',
        'codigoPostal',
        'ciudad',
        'pais',
        'email',
        'password',
    ];

    // Columnas ocultas en respuestas JSON
    protected $hidden = [
        'password', // Nunca exponer la contraseña
    ];

    public function bookings()
    {
        return $this->hasMany(TransferReserva::class, 'email_cliente', 'email');
    }
}
