<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferViajeros extends Model
{
    use HasFactory;

    protected $table = 'transfer_viajeros';
    protected $primaryKey = 'id_viajero';

    // Evita error de timestamps si no existen en la tabla
    public $timestamps = false;

    // Permitir asignación masiva de estos campos
    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'email',
        'direccion',
        'codigoPostal',  // asegúrate de que el campo en la BD se llama exactamente así
        'ciudad',
        'pais',
        'id_reserva',
    ];

    /**
     * Relación con la reserva (muchos viajeros pertenecen a una reserva)
     */
    public function reserva()
    {
        return $this->belongsTo(TransferReserva::class, 'id_reserva', 'id_reserva');
    }
}
