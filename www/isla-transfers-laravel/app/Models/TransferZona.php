<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferZona extends Model
{
    protected $table = 'transfer_zona'; 
    protected $primaryKey = 'id_zona'; 
    public $timestamps = false;         

    protected $fillable = [
        'descripcion',
    ];

    // Relación con hoteles
    public function hoteles()
    {
        return $this->hasMany(TransferHotel::class, 'id_zona', 'id_zona');
    }
}