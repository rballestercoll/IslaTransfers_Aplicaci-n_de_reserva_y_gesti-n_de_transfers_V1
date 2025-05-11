<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferPrecio extends Model
{
    protected $table = 'transfer_precios';
    protected $primaryKey = 'id_precios';
    public $timestamps = false;

    protected $fillable = [
        'id_vehiculo',
        'id_hotel',
        'precio',
    ];

    // Relaciones
    public function hotel()
    {
        return $this->belongsTo(TransferHotel::class, 'id_hotel');
    }

    public function vehiculo()
    {
        return $this->belongsTo(TransferVehiculo::class, 'id_vehiculo');
    }
}
