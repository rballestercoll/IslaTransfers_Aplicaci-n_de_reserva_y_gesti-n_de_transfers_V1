<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index()
    {
        $reservas = Reserva::with(['usuario','hotel','destino','tipo','vehiculo'])->get();
        return view('admin.index', compact('reservas'));
    }

    public function create()
    {
        return view('admin.create', [
            'hoteles'   => \App\Models\Hotel::all(),
            'vehiculos' => \App\Models\Vehiculo::all(),
            'tipos'     => \App\Models\TipoReserva::all(),
            'usuarios'  => \App\Models\User::where('rol','particular')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // Validar y crear reserva
        return redirect()->route('admin.index');
    }

    public function show(Reserva $reserva)
    {
        return view('admin.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        return view('admin.edit', compact('reserva'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Validar y actualizar
        return redirect()->route('admin.index');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return redirect()->route('admin.index');
    }
}
