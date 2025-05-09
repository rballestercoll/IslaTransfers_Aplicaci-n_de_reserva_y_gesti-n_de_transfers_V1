<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferHotel;

class AdminHotelController extends Controller
{
    public function index()
    {
        $hoteles = TransferHotel::all();
        return view('admin.hoteles.index', compact('hoteles'));
    }

    public function edit($id)
    {
        $hotel = TransferHotel::findOrFail($id);
        return view('admin.hoteles.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Comision' => 'required|numeric|min:0|max:100',
        ]);

        $hotel = TransferHotel::findOrFail($id);
        $hotel->Comision = $request->Comision;
        $hotel->save();

        return redirect('/admin/hoteles')->with('success', 'Comisión actualizada');
    }

    public function comisiones($id)
    {
        $hotel = TransferHotel::findOrFail($id);

        $resumen = \App\Models\TransferReserva::selectRaw('
                DATE_FORMAT(fecha_reserva, "%Y-%m") AS mes,
                COUNT(*) AS total_reservas,
                SUM(num_viajeros) AS total_viajeros,
                SUM(num_viajeros * ?) AS total_comision
            ', [$hotel->Comision]) // ← Esto estaba mal colocado
            ->where('id_hotel', $hotel->id_hotel)
            ->groupBy('mes')
            ->orderByDesc('mes')
            ->get();

        return view('admin.hoteles.comisiones', compact('hotel', 'resumen'));
    }

}


