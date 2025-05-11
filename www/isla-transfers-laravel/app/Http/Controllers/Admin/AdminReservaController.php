<?php
// =====================================================
// app/Http/Controllers/Admin/AdminReservaController.php
// =====================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{TransferReserva, TransferHotel};

class AdminReservaController extends Controller
{
    /*============================================================
    | RESERVA SOLO IDA  (Aeropuerto  -> Hotel)                   |
    ============================================================*/
    public function storeOneWay(Request $request)
    {
        $validated = $request->validate([
            'uuid'                => 'required|string|max:255',
            'bookingDate'         => 'required|date',
            'bookingTime'         => 'required',
            'flyNumber'           => 'required|string|max:255',
            'originAirport'       => 'required|string|max:255',
            'hotelSelect'         => 'required|integer',
            'carSelect'           => 'required|integer',
            'passengerNum'        => 'required|integer|min:1',
            'customerEmailSelect' => 'required|email',
        ]);

        /* Comprobamos que el hotel existe para no violar la FK.  
           Si no existe devolvemos error al formulario. */
        if (!TransferHotel::where('id_hotel', $validated['hotelSelect'])->exists()) {
            return back()->withErrors(['hotelSelect' => 'El hotel seleccionado no existe'])->withInput();
        }

        TransferReserva::create([
            'id_usuario'           => Auth::id() ?? 0,
            'localizador'          => $validated['uuid'],
            'id_hotel'             => $validated['hotelSelect'],
            'id_tipo_reserva'      => 1, // solo ida
            'email_cliente'        => $validated['customerEmailSelect'],
            'id_destino'           => $validated['hotelSelect'],
            'fecha_entrada'        => $validated['bookingDate'],
            'hora_entrada'         => $validated['bookingTime'],
            'numero_vuelo_entrada' => $validated['flyNumber'],
            'origen_vuelo_entrada' => $validated['originAirport'],
            'num_viajeros'         => $validated['passengerNum'],
            'id_vehiculo'          => $validated['carSelect'],
            'creado_por'           => 'admin',
            // Los campos de salida quedan null (permitido por la migration nullable)
        ]);

        return redirect()->route('admin.panel')->with('success', 'Reserva de ida creada correctamente');
    }

    /*============================================================
    | RESERVA SOLO VUELTA  (Hotel  -> Aeropuerto)                |
    ============================================================*/
    public function storeReturn(Request $request)
    {
        $validated = $request->validate([
            'uuid'                => 'required|string|max:255',
            'dateFly'             => 'required|date',
            'timeFly'             => 'required',
            'pickupTime'          => 'required',
            'hotelSelect'         => 'required|integer',
            'carSelect'           => 'required|integer',
            'passengerNum'        => 'required|integer|min:1',
            'customerEmailSelect' => 'required|email',
        ]);

        if (!TransferHotel::where('id_hotel', $validated['hotelSelect'])->exists()) {
            return back()->withErrors(['hotelSelect' => 'El hotel seleccionado no existe'])->withInput();
        }

        TransferReserva::create([
            'id_usuario'           => Auth::id() ?? 0,
            'localizador'          => $validated['uuid'],
            'id_hotel'             => $validated['hotelSelect'],
            'id_tipo_reserva'      => 2, // solo vuelta
            'email_cliente'        => $validated['customerEmailSelect'],
            'id_destino'           => $validated['hotelSelect'],
            'fecha_vuelo_salida'   => $validated['dateFly'],
            'hora_vuelo_salida'    => $validated['timeFly'],
            'hora_recogida_salida' => $validated['pickupTime'],
            'num_viajeros'         => $validated['passengerNum'],
            'id_vehiculo'          => $validated['carSelect'],
            'creado_por'           => 'admin',
        ]);

        return redirect()->route('admin.panel')->with('success', 'Reserva de vuelta creada correctamente');
    }

    /*============================================================
    | RESERVA IDA + VUELTA                                       |
    ============================================================*/
    public function storeRoundTrip(Request $request)
    {
        $validated = $request->validate([
            'uuid'                => 'required|string|max:255',
            'bookingDate'         => 'required|date',
            'bookingTime'         => 'required',
            'flyNumber'           => 'required|string|max:255',
            'originAirport'       => 'required|string|max:255',
            'dateFly'             => 'required|date',
            'timeFly'             => 'required',
            'pickupTime'          => 'required',
            'hotelSelect'         => 'required|integer',
            'carSelect'           => 'required|integer',
            'passengerNum'        => 'required|integer|min:1',
            'customerEmailSelect' => 'required|email',
        ]);

        if (!TransferHotel::where('id_hotel', $validated['hotelSelect'])->exists()) {
            return back()->withErrors(['hotelSelect' => 'El hotel seleccionado no existe'])->withInput();
        }

        TransferReserva::create([
            'id_usuario'           => Auth::id() ?? 0,
            'localizador'          => $validated['uuid'],
            'id_hotel'             => $validated['hotelSelect'],
            'id_tipo_reserva'      => 3, // ida + vuelta
            'email_cliente'        => $validated['customerEmailSelect'],
            'id_destino'           => $validated['hotelSelect'],
            // Ida
            'fecha_entrada'        => $validated['bookingDate'],
            'hora_entrada'         => $validated['bookingTime'],
            'numero_vuelo_entrada' => $validated['flyNumber'],
            'origen_vuelo_entrada' => $validated['originAirport'],
            // Vuelta
            'fecha_vuelo_salida'   => $validated['dateFly'],
            'hora_vuelo_salida'    => $validated['timeFly'],
            'hora_recogida_salida' => $validated['pickupTime'],
            'num_viajeros'         => $validated['passengerNum'],
            'id_vehiculo'          => $validated['carSelect'],
            'creado_por'           => 'admin',
        ]);

        return redirect()->route('admin.panel')->with('success', 'Reserva de ida y vuelta creada correctamente');
    }



    public function show($id)
    {
        $reserva = \App\Models\TransferReserva::findOrFail($id);
        return response()->json($reserva);
    }

    public function update(Request $request, $id)
    {
        $reserva = \App\Models\TransferReserva::findOrFail($id);
        $tipo = $request->input('tipoReserva');

        $request->validate([
            'uuid' => 'required|string|max:255',
            'customerEmailSelect' => 'required|email',
            'hotelSelect' => 'nullable|integer',
            'carSelect' => 'nullable|integer',
            'passengerNum' => 'nullable|integer|min:1',
        ]);

        $data = [
            'localizador' => $request->uuid,
            'email_cliente' => $request->customerEmailSelect,
            'id_destino' => $request->hotelSelect,
            'id_vehiculo' => $request->carSelect,
            'num_viajeros' => $request->passengerNum,
        ];

        if (($tipo == 1 || $tipo == 3) && $request->filled('bookingDate')) {
            $data['fecha_entrada'] = $request->bookingDate;
            $data['hora_entrada'] = $request->bookingTime;
            $data['numero_vuelo_entrada'] = $request->flyNumer;
            $data['origen_vuelo_entrada'] = $request->originAirport;
        }


        if ($tipo == 2 || $tipo == 3) {
            $data['fecha_vuelo_salida'] = $request->dateFly;
            $data['hora_vuelo_salida'] = $request->timeFly;
            $data['hora_recogida_salida'] = $request->pickupTime;
        }
        $data['fecha_modificacion'] = now();
        $reserva->update($data);


        $reserva->update($data);

        return redirect()->route('admin.panel')->with('success', 'Reserva actualizada correctamente.');
    }


    public function destroy($id)
    {
        $reserva = TransferReserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.panel')->with('success', 'Reserva eliminada correctamente.');
    }
    public function list()
    {
        $reservas = TransferReserva::orderBy('fecha_reserva', 'desc')->get();
        return view('panel.admin_list', compact('reservas'));
    }

    public function estadisticasPorZona()
{
    if (!session()->has('id_admin')) {
        return response()->json(['error' => 'Acceso no autorizado.'], 403);
    }

    $total = DB::table('transfer_reservas')->count();

    $estadisticas = DB::table('transfer_reservas')
        ->join('transfer_hotel', 'transfer_reservas.id_destino', '=', 'transfer_hotel.id_hotel')
        ->join('transfer_zona', 'transfer_hotel.id_zona', '=', 'transfer_zona.id_zona')
        ->select('transfer_zona.descripcion', DB::raw('COUNT(*) as num_reservas'))
        ->groupBy('transfer_zona.descripcion')
        ->get()
        ->map(function ($zona) use ($total) {
            $zona->porcentaje = round(($zona->num_reservas / $total) * 100, 2);
            return $zona;
        });

    return response()->json($estadisticas, 200, [], JSON_PRETTY_PRINT);

}

}
