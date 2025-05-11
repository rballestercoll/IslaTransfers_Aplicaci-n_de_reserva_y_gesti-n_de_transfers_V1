<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferVehiculo extends Model
{
    use HasFactory;

    protected $table = 'transfer_vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'email_conductor',
        'password',
    ];

    // Columnas ocultas en respuestas JSON
    protected $hidden = [
        'password', // Nunca exponer la contraseña
    ];

    
}
