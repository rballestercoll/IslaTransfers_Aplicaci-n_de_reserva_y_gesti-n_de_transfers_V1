<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferReserva;
use App\Models\TransferHotel;
use App\Models\TransferVehiculo;

class AdminReservaController extends Controller
{
    public function index(Request $request)
    {
        $query = TransferReserva::with(['hotel', 'vehiculo', 'viajeros']);

        if ($request->filled(['inicio', 'fin'])) {
            $query->whereBetween('fecha_reserva', [$request->inicio . ' 00:00:00', $request->fin . ' 23:59:59']);
        }

        $reservas = $query->get();

        return view('admin.reservas.index', compact('reservas'));
    }

    public function show($id)
    {
        $reserva = TransferReserva::with(['hotel', 'vehiculo', 'viajeros'])->findOrFail($id);
        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit($id)
    {
        $reserva = TransferReserva::findOrFail($id);
        return view('admin.reservas.edit', compact('reserva'));
    }

    public function update(Request $request, $id)
    {
        $reserva = TransferReserva::findOrFail($id);

        $reserva->fecha_reserva         = $request->fecha_reserva;
        $reserva->fecha_modificacion    = now();
        $reserva->fecha_entrada         = $request->fecha_entrada;
        $reserva->hora_entrada          = $request->hora_entrada;
        $reserva->fecha_vuelo_salida    = $request->fecha_vuelo_salida;
        $reserva->hora_vuelo_salida     = $request->hora_vuelo_salida;
        $reserva->hora_recogida         = $request->hora_recogida;
        $reserva->num_viajeros          = $request->num_viajeros;
        $reserva->email_cliente         = $request->email_cliente;
        $reserva->numero_vuelo_entrada  = $request->numero_vuelo_entrada;
        $reserva->numero_vuelo_salida   = $request->numero_vuelo_salida;
        $reserva->origen_vuelo_entrada  = $request->origen_vuelo_entrada;
        $reserva->creado_por            = $request->creado_por;

        $reserva->save();

        return redirect()->back()->with('success', 'Reserva actualizada correctamente');
    }

    public function destroy($id)
    {
        $reserva = TransferReserva::findOrFail($id);
        $reserva->delete();

        return redirect('/admin/reservas')->with('success', 'Reserva cancelada');
    }
}
