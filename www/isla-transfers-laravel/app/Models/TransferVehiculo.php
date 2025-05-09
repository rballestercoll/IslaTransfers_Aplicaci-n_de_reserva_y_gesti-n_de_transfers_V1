<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferVehiculo extends Model
{
    use HasFactory;

    protected $table = 'transfer_vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $incrementing = false;
    public $timestamps = false;
}
