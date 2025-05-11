<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TransferReserva;
use App\Models\TransferViajero;
use App\Models\TransferHotel;
use App\Models\TransferVehiculo;

class HotelController extends Controller
{
    public function index()
    {
        if (!Session::has('id_hotel')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }

        $emails = TransferViajero::pluck('email');
        $hoteles = TransferHotel::all();
        $vehiculos = TransferVehiculo::all();

        $oneWayBookings = $this->getOneWayBookings();
        $returnBookings = $this->getReturnBookings();
        $roundTripBookings = $this->getRoundTripBookings();

        return view('panel.hotel.corporative', compact('emails', 'hoteles', 'vehiculos', 'oneWayBookings', 'returnBookings', 'roundTripBookings'));
    }

    // Obtener las reservas de IDA registradas
    public function getOneWayBookings()
    {
        $hotel = Session('id_hotel');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('id_hotel', $hotel)->whereNull('fecha_vuelo_salida')->get();
    }

    // añade una reserva de IDA
    public function storeOneWay(Request $request)
    {
        if (!Session::has('id_hotel')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }
        $request->validate([
            'hotelUUID' => 'required|string|max:255',
            'hotel_fecha_entrada' => 'required|date',
            'hotel_hora_entrada' => 'required',
            'hotel_numero_vuelo_entrada' => 'required|string|max:255',
            'hotel_origen_vuelo_entrada' => 'required|string|max:255',
            'hotel_vehiculo' => 'required|integer',
            'hotel_num_viajeros' => 'required|integer|min:1',
            'hotelCustomerEmail' => 'required|email',
        ]);

        TransferReserva::create([
            'localizador' => $request->hotelUUID,
            'fecha_entrada' => $request->hotel_fecha_entrada,
            'hora_entrada' => $request->hotel_hora_entrada,
            'numero_vuelo_entrada' => $request->hotel_numero_vuelo_entrada,
            'origen_vuelo_entrada' => $request->hotel_origen_vuelo_entrada,
            'id_hotel' => session('id_hotel'),
            'id_destino' => session('id_hotel'),
            'id_vehiculo' => $request->hotel_vehiculo,
            'num_viajeros' => $request->hotel_num_viajeros,
            'email_cliente' => $request->hotelCustomerEmail,
            'id_tipo_reserva' => 2 // Tipo hotel
        ]);

        return redirect()->route('corp.panel')->with('success', 'Reserva de ida registrada correctamente');
    }


    // Obtener las reservas de VUELTA registradas
    public function getReturnBookings()
    {
        $hotel = Session('id_hotel');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('id_hotel', $hotel)->whereNull('fecha_entrada')->get();
    }


    // añade una reserva de VUELTA
    public function storeReturn(Request $request)
    {
        if (!Session::has('id_hotel')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }
        $request->validate([
            'rhotelUUID' => 'required|string|max:255',
            'rhotel_fecha_vuelo_salida' => 'required|date',
            'rhotel_hora_vuelo_salida' => 'required',
            'rhotel_hora_recogida_salida' => 'required',
            'rhotel_vehiculo' => 'required|integer',
            'rhotel_num_viajeros' => 'required|integer|min:1',
            'rhotelCustomerEmail' => 'required|email',
        ]);

        TransferReserva::create([
            'localizador' => $request->rhotelUUID,
            'fecha_vuelo_salida' => $request->rhotel_fecha_vuelo_salida,
            'hora_vuelo_salida' => $request->rhotel_hora_vuelo_salida,
            'hora_recogida_salida' => $request->rhotel_hora_recogida_salida,
            'id_hotel' => session('id_hotel'),
            'id_destino' => session('id_hotel'),
            'id_vehiculo' => $request->rhotel_vehiculo,
            'num_viajeros' => $request->rhotel_num_viajeros,
            'email_cliente' => $request->rhotelCustomerEmail,
            'id_tipo_reserva' => 2 // Tipo hotel
        ]);

        return redirect()->route('corp.panel')->with('success', 'Reserva de vuelta registrada correctamente');
    }


    // Obtener las reservas de IDA-VUELTA registradas
    public function getRoundTripBookings()
    {
        $hotel = Session('id_hotel');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('id_hotel', $hotel)->whereNotNull('fecha_entrada')->whereNotNull('fecha_vuelo_salida')->get();
    }

    // añade una reserva de IDA-VUELTA
    public function storeRoundTrip(Request $request)
    {
        if (!Session::has('id_hotel')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }
        $request->validate([
            'rthotelUUID' => 'required|string|max:255',
            'rthotel_fecha_entrada' => 'required|date',
            'rthotel_hora_entrada' => 'required',
            'rthotel_numero_vuelo_entrada' => 'required|string|max:255',
            'rthotel_origen_vuelo_entrada' => 'required|string|max:255',
            'rthotel_fecha_vuelo_salida' => 'required|date',
            'rthotel_hora_vuelo_salida' => 'required',
            'rthotel_hora_recogida_salida' => 'required',
            'rthotel_vehiculo' => 'required|integer',
            'rthotel_num_viajeros' => 'required|integer|min:1',
            'rthotelCustomerEmail' => 'required|email',
        ]);

        TransferReserva::create([
            'localizador' => $request->rthotelUUID,
            'fecha_entrada' => $request->rthotel_fecha_entrada,
            'hora_entrada' => $request->rthotel_hora_entrada,
            'numero_vuelo_entrada' => $request->rthotel_numero_vuelo_entrada,
            'origen_vuelo_entrada' => $request->rthotel_origen_vuelo_entrada,
            'fecha_vuelo_salida' => $request->rthotel_fecha_vuelo_salida,
            'hora_vuelo_salida' => $request->rthotel_hora_vuelo_salida,
            'hora_recogida_salida' => $request->rthotel_hora_recogida_salida,
            'id_hotel' => session('id_hotel'),
            'id_destino' => session('id_hotel'),
            'id_vehiculo' => $request->rthotel_vehiculo,
            'num_viajeros' => $request->rthotel_num_viajeros,
            'email_cliente' => $request->rthotelCustomerEmail,
            'id_tipo_reserva' => 2 // Tipo hotel
        ]);

        return redirect()->route('corp.panel')->with('success', 'Reserva de ida-vuelta registrada correctamente');
    }

    public function updateOneWay(Request $request)
    {

        $reserva = TransferReserva::find($request->id);

        if (!$reserva) {
            return redirect()->back()->with('error', 'Reserva no encontrada.');
        }

        $reserva->update([
            'email_cliente' => $request->email_cliente,
            'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
            'fecha_entrada' => $request->fecha_entrada,
            'hora_entrada' => $request->hora_entrada,
            'origen_vuelo_entrada' => $request->origen_vuelo_entrada,
            'num_viajeros' => $request->num_viajeros,
            'id_vehiculo' => $request->id_vehiculo,
        ]);

        return redirect()->back()->with('success', 'Reserva actualizada correctamente.');
    }

    public function updateReturn(Request $request)
    {
        $reserva = TransferReserva::find($request->id);

        if (!$reserva) {
            return redirect()->back()->with('error', 'Reserva no encontrada.');
        }

        $reserva->update([
            'email_cliente' => $request->email_cliente,
            'fecha_vuelo_salida' => $request->fecha_vuelo_salida,
            'hora_vuelo_salida' => $request->hora_vuelo_salida,
            'hora_recogida_salida' => $request->hora_recogida_salida,
            'num_viajeros' => $request->num_viajeros,
            'id_vehiculo' => $request->id_vehiculo,
        ]);

        return redirect()->back()->with('success', 'Reserva de vuelta actualizada correctamente.');
    }

    public function updateRoundTrip(Request $request)
    {
        $reserva = TransferReserva::find($request->id);

        if (!$reserva) {
            return redirect()->back()->with('error', 'Reserva no encontrada.');
        }

        $reserva->update([
            'email_cliente' => $request->email_cliente,
            'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
            'fecha_entrada' => $request->fecha_entrada,
            'hora_entrada' => $request->hora_entrada,
            'origen_vuelo_entrada' => $request->origen_vuelo_entrada,
            'fecha_vuelo_salida' => $request->fecha_vuelo_salida,
            'hora_vuelo_salida' => $request->hora_vuelo_salida,
            'hora_recogida_salida' => $request->hora_recogida_salida,
            'num_viajeros' => $request->num_viajeros,
            'id_vehiculo' => $request->id_vehiculo,
        ]);

        return redirect()->back()->with('success', 'Reserva ida-vuelta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $reserva = TransferReserva::find($id);

        if (!$reserva) {
            return redirect()->back()->with('error', 'Reserva no encontrada para eliminar.');
        }

        $reserva->delete();

        return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
    }
}
