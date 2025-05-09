<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferHotel;
use App\Models\TransferVehiculo;

class TransferReserva extends Model
{
    use HasFactory;

    protected $table = 'transfer_reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    // Relación con el hotel
    public function hotel()
    {
        return $this->belongsTo(TransferHotel::class, 'id_hotel', 'id_hotel');
    }

    // Relación con el vehículo
    public function vehiculo()
    {
        return $this->belongsTo(TransferVehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    // Relación con tipo de reserva (ida, vuelta, ambas)
    public function tipo()
    {
        return $this->belongsTo(TransferTipoReserva::class, 'id_tipo_reserva');
    }

    // Relación con los viajeros (uno a muchos)
    public function viajeros()
    {
        return $this->hasMany(TransferViajeros::class, 'id_reserva', 'id_reserva');
    }
}
