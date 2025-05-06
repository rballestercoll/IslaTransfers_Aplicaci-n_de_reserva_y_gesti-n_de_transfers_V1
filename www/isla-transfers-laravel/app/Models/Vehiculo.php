<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'transfer_vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'email_conductor',
        'password',
    ];

    public function precios()
    {
        return $this->hasMany(Precio::class, 'id_vehiculo', 'id_vehiculo');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_vehiculo', 'id_vehiculo');
    }
}
