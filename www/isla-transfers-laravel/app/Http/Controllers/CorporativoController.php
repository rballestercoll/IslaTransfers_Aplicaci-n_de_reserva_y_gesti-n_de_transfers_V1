<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class CorporativoController extends Controller
{
    public function dashboard()
    {
        // Mostrar reservas que este hotel ha creado
        $reservas = Reserva::where('email_cliente', auth()->user()->email)
                           ->with(['hotel','destino','tipo','vehiculo'])
                           ->get();

        return view('corporativo.dashboard', compact('reservas'));
    }

    // Puedes añadir métodos create/store/index análogos a AdminController
}
