<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Hotel;
use App\Models\Vehiculo;
use App\Models\TipoReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function __construct()
    {
        // Sólo usuarios autenticados pueden acceder
        $this->middleware('auth');
        // Para los métodos de edición y borrado, aplicamos comprobación de propietario
        $this->middleware('role:particular')->only(['create','store','edit','update','destroy']);
    }

    /** Lista las reservas del usuario particular */
    public function index()
    {
        $user = Auth::user();
        $reservas = Reserva::with(['hotel','destino','tipo','vehiculo'])
            ->where('id_usuario', $user->id_usuario)
            ->orderBy('fecha_reserva','desc')
            ->get();

        return view('reservas.index', compact('reservas'));
    }

    /** Muestra el formulario de nueva reserva */
    public function create()
    {
        return view('reservas.create', [
            'hoteles'   => Hotel::all(),
            'vehiculos' => Vehiculo::all(),
            'tipos'     => TipoReserva::all(),
        ]);
    }

    /** Guarda la reserva nueva, con validaciones y 48 h */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo_reserva'      => 'required|in:1,2,3',
            'id_hotel'             => 'required|integer|exists:transfer_hotel,id_hotel',
            'id_destino'           => 'required|integer|exists:transfer_hotel,id_hotel',
            'id_vehiculo'          => 'required|integer|exists:transfer_vehiculo,id_vehiculo',
            'num_viajeros'         => 'required|integer|min:1',
            // los campos de vuelo/entrada se validan a posteriori
        ]);

        // Validación de campos según tipo
        $tipo = $data['id_tipo_reserva'];
        if ($tipo == 1 || $tipo == 3) {
            $request->validate([
                'fecha_entrada'        => 'required|date',
                'hora_entrada'         => 'required',
                'numero_vuelo_entrada' => 'required|string',
                'origen_vuelo_entrada' => 'required|string',
            ]);
        }
        if ($tipo == 2 || $tipo == 3) {
            $request->validate([
                'fecha_vuelo_salida'   => 'required|date',
                'hora_vuelo_salida'    => 'required',
            ]);
        }

        // Comprobación 48 horas: fecha más próxima (entrada o salida)
        $fechaHora = null;
        if ($tipo == 1) {
            $fechaHora = Carbon::parse($request->fecha_entrada . ' ' . $request->hora_entrada);
        } elseif ($tipo == 2) {
            $fechaHora = Carbon::parse($request->fecha_vuelo_salida . ' ' . $request->hora_vuelo_salida);
        } else {
            // Ida y vuelta → comparamos la más lejana (puede adaptar)
            $in = Carbon::parse($request->fecha_entrada . ' ' . $request->hora_entrada);
            $out = Carbon::parse($request->fecha_vuelo_salida . ' ' . $request->hora_vuelo_salida);
            $fechaHora = $in->lt($out) ? $in : $out;
        }
        if ($fechaHora->lt(Carbon::now()->addHours(48))) {
            return back()
                ->withInput()
                ->withErrors(['fecha_entrada' => 'La reserva debe hacerse al menos con 48 horas de antelación.']);
        }

        // Rellenamos el array final
        $reservaData = [
            'id_usuario'           => Auth::id(),
            'email_cliente'        => Auth::user()->email,
            'localizador'          => 'RES_'.Str::upper(Str::random(6)),
            'id_hotel'             => $data['id_hotel'],
            'id_tipo_reserva'      => $tipo,
            'fecha_reserva'        => now(),
            'fecha_modificacion'   => now(),
            'id_destino'           => $data['id_destino'],
            'fecha_entrada'        => $request->input('fecha_entrada'),
            'hora_entrada'         => $request->input('hora_entrada'),
            'numero_vuelo_entrada' => $request->input('numero_vuelo_entrada'),
            'origen_vuelo_entrada' => $request->input('origen_vuelo_entrada'),
            'fecha_vuelo_salida'   => $request->input('fecha_vuelo_salida'),
            'hora_vuelo_salida'    => $request->input('hora_vuelo_salida'),
            'numero_vuelo_salida'  => $request->input('numero_vuelo_salida'),
            'hora_recogida'        => $request->input('hora_recogida'),
            'num_viajeros'         => $data['num_viajeros'],
            'id_vehiculo'          => $data['id_vehiculo'],
            'creado_por'           => 'usuario',
        ];

        $reserva = Reserva::create($reservaData);

        // Envío de correo de confirmación
        Mail::to($reserva->email_cliente)
            ->send(new ReservaConfirmada($reserva));

        return redirect()->route('reservas.index')
                         ->with('status','✅ Reserva creada correctamente. '
                             .'Te hemos enviado confirmación por email.');
    }

    /** Muestra el detalle de una reserva */
    public function show(Reserva $reserva)
    {
        // Sólo propietario o admin
        if (Auth::id() !== $reserva->id_usuario) abort(403);
        return view('reservas.show', compact('reserva'));
    }

    /** Formulario de edición, con 48 h */
    public function edit(Reserva $reserva)
    {
        if (Auth::id() !== $reserva->id_usuario) abort(403);

        $fechaHora = Carbon::parse($reserva->fecha_entrada.' '.$reserva->hora_entrada);
        if ($fechaHora->lt(Carbon::now()->addHours(48))) {
            return redirect()->route('reservas.index')
                ->withErrors(['edit' => 'No se puede editar con menos de 48 horas de antelación.']);
        }

        return view('reservas.edit', [
            'reserva'   => $reserva,
            'hoteles'   => Hotel::all(),
            'vehiculos' => Vehiculo::all(),
            'tipos'     => TipoReserva::all(),
        ]);
    }

    /** Actualiza la reserva */
    public function update(Request $request, Reserva $reserva)
    {
        if (Auth::id() !== $reserva->id_usuario) abort(403);

        // Repetimos validaciones de store (puedes extraerlo a un FormRequest)
        // ...

        // Actualizar campos permitidos
        $reserva->fill($request->only([
            'id_tipo_reserva','id_hotel','id_destino',
            'fecha_entrada','hora_entrada','numero_vuelo_entrada','origen_vuelo_entrada',
            'fecha_vuelo_salida','hora_vuelo_salida','numero_vuelo_salida','hora_recogida',
            'num_viajeros','id_vehiculo',
        ]));
        $reserva->fecha_modificacion = now();
        $reserva->save();

        return redirect()->route('reservas.index')
                         ->with('status','✅ Reserva actualizada correctamente.');
    }

    /** Cancela (elimina) la reserva */
    public function destroy(Reserva $reserva)
    {
        if (Auth::id() !== $reserva->id_usuario) abort(403);

        $fechaHora = Carbon::parse($reserva->fecha_entrada.' '.$reserva->hora_entrada);
        if ($fechaHora->lt(Carbon::now()->addHours(48))) {
            return redirect()->route('reservas.index')
                ->withErrors(['delete' => 'No se puede cancelar con menos de 48 horas.']);
        }

        $reserva->delete();

        return redirect()->route('reservas.index')
                         ->with('status','✅ Reserva cancelada correctamente.');
    }
}
