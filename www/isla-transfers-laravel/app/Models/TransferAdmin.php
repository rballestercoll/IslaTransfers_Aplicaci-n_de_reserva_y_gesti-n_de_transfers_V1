<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferAdmin extends Authenticatable
{
    use HasFactory;

    // Configuración exacta de la tabla
    protected $table = 'transfer_admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false; // Sin timestamps (no hay created_at/updated_at)

    // Columnas fillable (asignables masivamente)
    protected $fillable = [
        'nombre',
        'email_admin',
        'password',
    ];

    // Columnas ocultas en respuestas JSON
    protected $hidden = [
        'password',
    ];

    // Método para estandarizar el campo email (opcional pero útil)
    public function getEmailAttribute()
    {
        return $this->email_admin; // Permite usar Auth::user()->email
    }

}