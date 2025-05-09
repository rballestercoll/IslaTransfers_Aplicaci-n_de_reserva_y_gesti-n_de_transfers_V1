<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferZona extends Model
{
    use HasFactory;
    protected $table = 'transfer_zona';
    protected $primaryKey = 'id_zona';
}
