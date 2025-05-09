<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferReserva;
use App\Models\TransferViajeros;

class AdminViajeroController extends Controller
{
    public function create($reservaId)
    {
        $reserva = TransferReserva::findOrFail($reservaId);
        return view('admin.viajeros.create', compact('reserva'));
    }

    public function store(Request $request, $reservaId)
    {
        $reserva = TransferReserva::findOrFail($reservaId);

        $viajero = new TransferViajeros();
        $viajero->nombre = $request->nombre;
        $viajero->apellido1 = $request->apellido1;
        $viajero->apellido2 = $request->apellido2;
        $viajero->email = $request->email;
        $viajero->direccion = $request->direccion;
        $viajero->codigoPostal = $request->codigoPostal;
        $viajero->ciudad = $request->ciudad;
        $viajero->pais = $request->pais;
        $viajero->id_reserva = $reserva->id_reserva;
        $viajero->save();

        return redirect('/admin/reservas/' . $reserva->id_reserva)
               ->with('success', 'Viajero añadido correctamente');
    }
}
