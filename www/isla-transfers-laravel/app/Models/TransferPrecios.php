<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferPrecios extends Model
{
    use HasFactory;
    protected $table = 'transfer_precios';
    protected $primaryKey = 'id_precios';
}
