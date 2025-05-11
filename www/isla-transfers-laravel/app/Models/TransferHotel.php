<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferHotel extends Authenticatable
{
    use HasFactory;

    // Configuración exacta de la tabla
    protected $table = 'transfer_hotel';
    protected $primaryKey = 'id_hotel';
    public $timestamps = false; // Sin timestamps (no hay created_at/updated_at)

    // Columnas fillable (asignables masivamente)
    protected $fillable = [
        'nombre_hotel',
        'id_zona',
        'comision',
        'email_hotel',
        'password',
    ];

    // Columnas ocultas en respuestas JSON
    protected $hidden = [
        'password',
    ];

    // Relación con zona
    public function zona()
    {
        return $this->belongsTo(TransferZona::class, 'id_zona', 'id_zona');
    }

    // ✅ Relación con reservas
    public function reservas()
    {
        return $this->hasMany(\App\Models\TransferReserva::class, 'id_hotel', 'id_hotel');
    }
}
