<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $fillable = ['nombre', 'email', 'password', 'rol'];

    protected $hidden = ['password'];

    public $timestamps = false;
}

