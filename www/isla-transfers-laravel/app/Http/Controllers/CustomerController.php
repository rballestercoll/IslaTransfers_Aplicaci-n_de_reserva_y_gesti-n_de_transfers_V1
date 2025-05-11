<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferReserva;
use App\Models\TransferHotel;
use App\Models\TransferVehiculo;
use Illuminate\Support\Facades\Session;
use DateTime;


class CustomerController extends Controller
{
    public function panel()
    {
        return view('panel.customer');
    }

    // muestra las reservas filtrando por el email de la Session
    public function showBookingsByEmail()
    {
        $oneWayBookings = $this->getOneWayBookings();
        $returnBookings = $this->getReturnBookings();
        $roundTripBookings = $this->getRoundTripBookings();

        $hoteles = TransferHotel::all();
        $vehiculos = TransferVehiculo::all();

        return view('panel.customer', compact('oneWayBookings', 'returnBookings', 'roundTripBookings', 'hoteles', 'vehiculos'));
    }

    // Obtiene las reservas por email de IDA
    public function getOneWayBookings()
    {
        $email = Session('email');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('email_cliente', $email)->whereNull('fecha_vuelo_salida')->get();
    }

    // Añade una reserva de IDA
    public function storeOneWay(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string|max:100',
            'id_hotel' => 'required|integer',
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'required',
            'numero_vuelo_entrada' => 'required|string|max:50',
            'origen_vuelo_entrada' => 'required|string|max:50',
            'num_viajeros' => 'required|integer|min:1',
            'id_vehiculo' => 'required|integer',
        ]);

        try {
            // Combina fecha y hora de entrada
            $entrada = DateTime::createFromFormat('Y-m-d H:i', $request->fecha_entrada . ' ' . $request->hora_entrada);
            $ahora = new DateTime();

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($entrada < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las reservas deben realizarse con al menos 48 horas de antelación.');
            }

            TransferReserva::create([
                'localizador' => $request->uuid,
                'fecha_reserva' => now(),
                'id_tipo_reserva' => 1,
                'email_cliente' => session('email'),
                'id_destino' => $request->id_hotel,
                'fecha_entrada' => $request->fecha_entrada,
                'hora_entrada' => $request->hora_entrada,
                'numero_vuelo_entrada' => $request->numero_vuelo_entrada,
                'origen_vuelo_entrada' => $request->origen_vuelo_entrada,
                'num_viajeros' => $request->num_viajeros,
                'id_vehiculo' => $request->id_vehiculo,
            ]);

            return redirect()->back()->with('success', 'Reserva de ida registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'fecha_entrada' => 'Error al procesar la reserva: ' . $e->getMessage()
            ])->withInput();
        }
    }

    // Modifica una reserva de IDA
    public function updateOneWay(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer|exists:transfer_reservas,id_reserva',
            'edit_fecha_entrada' => 'required|date',
            'edit_hora_entrada' => 'required',
            'edit_numero_vuelo_entrada' => 'required|string|max:50',
            'edit_origen_vuelo_entrada' => 'required|string|max:50',
            'edit_num_viajeros' => 'required|integer|min:1',
            'edit_id_vehiculo' => 'required|integer',
            'edit_id_hotel' => 'required|integer',
        ]);

        $reserva = TransferReserva::find($request->id_reserva);

        try {
            $entrada = DateTime::createFromFormat('Y-m-d H:i', $request->edit_fecha_entrada . ' ' . $request->edit_hora_entrada);
            $ahora = new DateTime();

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($entrada < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las modificaciones deben hacerse con al menos 48 horas de antelación.');
            }

            $reserva->update([
                'fecha_modificacion' => now(),
                'fecha_entrada' => $request->edit_fecha_entrada,
                'hora_entrada' => $request->edit_hora_entrada,
                'numero_vuelo_entrada' => $request->edit_numero_vuelo_entrada,
                'origen_vuelo_entrada' => $request->edit_origen_vuelo_entrada,
                'num_viajeros' => $request->edit_num_viajeros,
                'id_vehiculo' => $request->edit_id_vehiculo,
                'id_destino' => $request->edit_id_hotel,
            ]);

            return redirect()->back()->with('success', 'Reserva de ida actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la reserva: ' . $e->getMessage());
        }
    }

    // Elimina una reserva de IDA
    public function destroyOneWay($id_reserva)
    {
        try {
            $reserva = TransferReserva::findOrFail($id_reserva);

            $entrada = DateTime::createFromFormat('Y-m-d H:i:s', $reserva->fecha_entrada . ' ' . $reserva->hora_entrada);
            $ahora = new DateTime();

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($horasDiff < 48) {
                return redirect()->back()->with('error', 'No se puede eliminar una reserva dentro de las 48 horas previas a la entrada.');
            }

            $reserva->delete();

            return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la reserva: ' . $e->getMessage());
        }
    }

    // Obtiene las reservas por email de VUELTA
    public function getReturnBookings()
    {
        $email = Session('email');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('email_cliente', $email)->whereNull('fecha_entrada')->get();
    }

    // Añade una reserva de VUELTA
    public function storeReturn(Request $request)
    {
        $request->validate([
            'ruuid' => 'required|string|max:100',
            'rid_hotel' => 'required|integer',
            'rfecha_vuelo_salida' => 'required|date',
            'rhora_vuelo_salida' => 'required',
            'rhora_recogida_salida' => 'required',
            'rnum_viajeros' => 'required|integer|min:1',
            'rid_vehiculo' => 'required|integer',
        ]);

        try {
            // Combina fecha y hora de recogida de salida (es la prestación real del servicio)
            $salida = DateTime::createFromFormat('Y-m-d H:i', $request->rfecha_vuelo_salida . ' ' . $request->rhora_vuelo_salida);
            $ahora = new DateTime();

            if (!$salida) {
                return redirect()->back()->with('error', 'La fecha u hora de recogida no es válida.');
            }

            $diff = $ahora->diff($salida);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($salida < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las reservas deben realizarse con al menos 48 horas de antelación.');
            }

            TransferReserva::create([
                'localizador' => $request->ruuid,
                'fecha_reserva' => now(),
                'id_tipo_reserva' => 1,
                'email_cliente' => session('email'),
                'id_destino' => $request->rid_hotel,
                'fecha_vuelo_salida' => $request->rfecha_vuelo_salida,
                'hora_vuelo_salida' => $request->rhora_vuelo_salida,
                'hora_recogida_salida' => $request->rhora_recogida_salida,
                'num_viajeros' => $request->rnum_viajeros,
                'id_vehiculo' => $request->rid_vehiculo,
            ]);

            return redirect()->back()->with('success', 'Reserva de vuelta registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la reserva: ' . $e->getMessage());
        }
    }

    // Modifica una reserva de VUELTA
    public function updateReturn(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer|exists:transfer_reservas,id_reserva',
            'editReturn_fecha_salida' => 'required|date',
            'editReturn_hora_salida' => 'required',
            'editReturn_hora_recogida_salida' => 'required',
            'editReturn_num_viajeros' => 'required|integer|min:1',
            'editReturn_id_vehiculo' => 'required|integer',
            'editReturn_id_hotel' => 'required|integer',
        ]);

        $reserva = TransferReserva::find($request->id_reserva);

        try {
            $salida = DateTime::createFromFormat('Y-m-d H:i', $request->editReturn_fecha_salida . ' ' . $request->editReturn_hora_salida);
            $ahora = new DateTime();

            $diff = $ahora->diff($salida);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($salida < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las modificaciones deben hacerse con al menos 48 horas de antelación.');
            }

            $reserva->update([
                'fecha_modificacion' => now(),
                'fecha_vuelo_salida' => $request->editReturn_fecha_salida,
                'hora_vuelo_salida' => $request->editReturn_hora_salida,
                'hora_recogida_salida' => $request->editReturn_hora_recogida_salida,
                'num_viajeros' => $request->editReturn_num_viajeros,
                'id_vehiculo' => $request->editReturn_id_vehiculo,
                'id_destino' => $request->editReturn_id_hotel,
            ]);

            return redirect()->back()->with('success', 'Reserva de vuelta actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la reserva: ' . $e->getMessage());
        }
    }

    // Elimina una reserva de VUELTA
    public function destroyReturn($id_reserva)
    {
        try {
            $reserva = TransferReserva::findOrFail($id_reserva);

            $salida = DateTime::createFromFormat('Y-m-d H:i:s', $reserva->fecha_vuelo_salida . ' ' . $reserva->hora_vuelo_salida);
            $ahora = new DateTime();

            $diff = $ahora->diff($salida);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($horasDiff < 48) {
                return redirect()->back()->with('error', 'No se puede eliminar una reserva dentro de las 48 horas previas a la salida.');
            }

            $reserva->delete();

            return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la reserva: ' . $e->getMessage());
        }
    }

    // Obtiene las reservas por email de IDA-VUELTA
    public function getRoundTripBookings()
    {
        $email = Session('email');

        return TransferReserva::with(['destinoHotel', 'descripcionVehiculo', 'realizadaPor'])->where('email_cliente', $email)->whereNotNull('fecha_entrada')->whereNotNull('fecha_vuelo_salida')->get();
    }

    // Añade una reserva de IDA-VUELTA
    public function storeRoundTrip(Request $request)
    {
        $request->validate([
            'rtuuid' => 'required|string|max:100',
            'rtid_hotel' => 'required|integer',
            'rtfecha_entrada' => 'required|date',
            'rthora_entrada' => 'required',
            'rtnumero_vuelo_entrada' => 'required|string|max:50',
            'rtorigen_vuelo_entrada' => 'required|string|max:50',
            'rtfecha_vuelo_salida' => 'required|date',
            'rthora_vuelo_salida' => 'required',
            'rthora_recogida_salida' => 'required',
            'rtnum_viajeros' => 'required|integer|min:1',
            'rtid_vehiculo' => 'required|integer',
        ]);

        try {
            // Combinar fecha y hora de entrada (inicio del servicio)
            $entrada = DateTime::createFromFormat('Y-m-d H:i', $request->rtfecha_entrada . ' ' . $request->rthora_entrada);
            $ahora = new DateTime();

            if (!$entrada) {
                return redirect()->back()->with('error', 'La fecha u hora de entrada no es válida.');
            }

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($entrada < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las reservas deben realizarse con al menos 48 horas de antelación.');
            }

            TransferReserva::create([
                'localizador' => $request->rtuuid,
                'fecha_reserva' => now(),
                'id_tipo_reserva' => 1,
                'email_cliente' => session('email'),
                'id_destino' => $request->rtid_hotel,
                'fecha_entrada' => $request->rtfecha_entrada,
                'hora_entrada' => $request->rthora_entrada,
                'numero_vuelo_entrada' => $request->rtnumero_vuelo_entrada,
                'origen_vuelo_entrada' => $request->rtorigen_vuelo_entrada,
                'fecha_vuelo_salida' => $request->rtfecha_vuelo_salida,
                'hora_vuelo_salida' => $request->rthora_vuelo_salida,
                'hora_recogida_salida' => $request->rthora_recogida_salida,
                'num_viajeros' => $request->rtnum_viajeros,
                'id_vehiculo' => $request->rtid_vehiculo,
            ]);

            return redirect()->back()->with('success', 'Reserva de ida-vuelta registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la reserva: ' . $e->getMessage());
        }
    }

    // Modifica una reserva IDA-VUELTA
    public function updateRoundTrip(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer|exists:transfer_reservas,id_reserva',
            'editRoundTrip_fecha_entrada' => 'required|date',
            'editRoundTrip_hora_entrada' => 'required',
            'editRoundTrip_numero_vuelo_entrada' => 'required|string|max:50',
            'editRoundTrip_origen_vuelo_entrada' => 'required|string|max:50',
            'editRoundTrip_fecha_vuelo_salida' => 'required|date',
            'editRoundTrip_hora_vuelo_salida' => 'required',
            'editRoundTrip_hora_recogida_salida' => 'required',
            'editRoundTrip_num_viajeros' => 'required|integer|min:1',
            'editRoundTrip_id_vehiculo' => 'required|integer',
            'editRoundTrip_id_hotel' => 'required|integer',
        ]);

        $reserva = TransferReserva::find($request->id_reserva);

        try {
            $entrada = DateTime::createFromFormat('Y-m-d H:i', $request->editRoundTrip_fecha_entrada . ' ' . $request->editRoundTrip_hora_entrada);
            $ahora = new DateTime();

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($entrada < $ahora || $horasDiff < 48) {
                return redirect()->back()->with('error', 'Las modificaciones deben hacerse con al menos 48 horas de antelación.');
            }

            $reserva->update([
                'fecha_modificacion' => now(),
                'fecha_entrada' => $request->editRoundTrip_fecha_entrada,
                'hora_entrada' => $request->editRoundTrip_hora_entrada,
                'numero_vuelo_entrada' => $request->editRoundTrip_numero_vuelo_entrada,
                'origen_vuelo_entrada' => $request->editRoundTrip_origen_vuelo_entrada,
                'fecha_vuelo_salida' => $request->editRoundTrip_fecha_vuelo_salida,
                'hora_vuelo_salida' => $request->editRoundTrip_hora_vuelo_salida,
                'hora_recogida_salida' => $request->editRoundTrip_hora_recogida_salida,
                'num_viajeros' => $request->editRoundTrip_num_viajeros,
                'id_vehiculo' => $request->editRoundTrip_id_vehiculo,
                'id_destino' => $request->editRoundTrip_id_hotel,
            ]);

            return redirect()->back()->with('success', 'Reserva de ida-vuelta actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la reserva: ' . $e->getMessage());
        }
    }

    // Elimina una reserva IDA-VUELTA
    public function destroyRoundTrip($id_reserva)
    {
        try {
            $reserva = TransferReserva::findOrFail($id_reserva);

            $entrada = DateTime::createFromFormat('Y-m-d H:i:s', $reserva->fecha_entrada . ' ' . $reserva->hora_entrada);
            $ahora = new DateTime();

            $diff = $ahora->diff($entrada);
            $horasDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

            if ($horasDiff < 48) {
                return redirect()->back()->with('error', 'No se puede eliminar una reserva dentro de las 48 horas previas a la entrada.');
            }

            $reserva->delete();

            return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la reserva: ' . $e->getMessage());
        }
    }


}
