<?php
// =============================================================
//  MODELO: app/Models/TransferReserva.php
// =============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferReserva extends Model
{
    use HasFactory;

    protected $table      = 'transfer_reservas';
    protected $primaryKey = 'id_reserva';

    /**
     * La tabla usa fecha_reserva / fecha_modificacion como timestamps
     */
    public $timestamps = true;
    const CREATED_AT   = 'fecha_reserva';
    const UPDATED_AT   = 'fecha_modificacion';

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'id_usuario',
        'localizador',
        'id_hotel',
        'id_tipo_reserva',
        'email_cliente',
        'id_destino',
        'fecha_entrada',
        'hora_entrada',
        'numero_vuelo_entrada',
        'origen_vuelo_entrada',
        'fecha_vuelo_salida',
        'hora_vuelo_salida',
        'numero_vuelo_salida',
        'hora_recogida',
        'hora_recogida_salida',
        'num_viajeros',
        'id_vehiculo',
        'creado_por',
    ];

    protected $casts = [
        'fecha_entrada'       => 'date',
        'fecha_vuelo_salida'  => 'date',
        'hora_entrada'        => 'datetime:H:i',
        'hora_vuelo_salida'   => 'datetime:H:i',
        'hora_recogida_salida'=> 'datetime:H:i',
        'fecha_reserva'       => 'datetime',
        'fecha_modificacion'  => 'datetime',
    ];

    // ================== RELACIONES ==================
    public function destinoHotel()   { return $this->belongsTo(TransferHotel   ::class, 'id_destino', 'id_hotel'); }
    public function hotel()          { return $this->belongsTo(TransferHotel   ::class, 'id_hotel',   'id_hotel'); }
    public function vehiculo()       { return $this->belongsTo(TransferVehiculo::class, 'id_vehiculo', 'id_vehiculo'); }
    public function realizadaPor()   { return $this->belongsTo(TransferTipoReserva::class, 'id_tipo_reserva'); }

    // ================== HELPERS ==================
    public function precioTransfer()
    {
        return TransferPrecio::where('id_hotel', $this->id_hotel)
                             ->where('id_vehiculo', $this->id_vehiculo)
                             ->first();
    }

    public function getPrecioAttribute()         { return $this->precioTransfer()?->precio ?? 0; }
    public function getComisionHotelAttribute()  { $c = $this->hotel?->comision ?? 0; return round(($this->precio * $c) / 100, 2); }
}