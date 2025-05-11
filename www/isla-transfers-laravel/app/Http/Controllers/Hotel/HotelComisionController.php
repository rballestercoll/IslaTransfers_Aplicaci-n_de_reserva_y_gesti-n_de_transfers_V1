<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferReserva;

class HotelComisionController extends Controller
{
    public function verComisionesMensuales()
    {
        $hotelId = session('id_hotel');

        $reservas = TransferReserva::where('id_hotel', $hotelId)
            ->whereMonth('fecha_reserva', now()->month)
            ->whereYear('fecha_reserva', now()->year)
            ->with(['vehiculo']) // si quieres mostrar más datos
            ->get();

        $totalComision = $reservas->sum('comision_hotel');

        return view('panel.hotel.commission', [
            'reservas' => $reservas,
            'totalComision' => $totalComision,
            'mes' => now()->format('F Y'),
        ]);
    }
}
