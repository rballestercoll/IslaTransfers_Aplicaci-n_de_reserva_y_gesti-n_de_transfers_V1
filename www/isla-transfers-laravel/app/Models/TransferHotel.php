<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferHotel extends Model
{
    use HasFactory;

    protected $table = 'transfer_hotel';
    protected $primaryKey = 'id_hotel';
    public $incrementing = false;
    public $timestamps = false;
}
