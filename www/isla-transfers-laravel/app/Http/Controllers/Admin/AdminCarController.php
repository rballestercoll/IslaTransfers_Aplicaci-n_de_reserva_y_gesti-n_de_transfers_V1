<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\TransferVehiculo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminCarController extends Controller
{
    public function index()
    {
        if (!Session::has('id_admin')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }

        $vehiculos = TransferVehiculo::all();

        return view('panel.admin.car.adminCar', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $request->validate([
            'descripcion' => 'required|string|max:100',
            'emailConductor' => 'required|email',
            'conductorPassword' => 'required|string|min:4',
        ]);

        try {
            TransferVehiculo::create([
                'descripcion' => $request->descripcion,
                'email_conductor' => $request->emailConductor,
                'password' => Hash::make($request->conductorPassword),
            ]);

            return redirect()->route('admin.vehiculos.index')->with('success', 'Hotel registrado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.vehiculos.index')
                ->with('error', 'El email del conductor ya está registrado en el sistema.');
        }
    }

    public function update(Request $request)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $vehiculo = TransferVehiculo::findOrFail($request->id_vehiculo);

        try {
            $request->validate([
                'descripcion' => 'required|string|max:100',
                'email_conductor' => 'required|email|unique:transfer_vehiculo,email_conductor,' . $vehiculo->id_vehiculo . ',id_vehiculo',
            ]);

            $updateData = [
                'descripcion' => $request->descripcion,
                'email_conductor' => $request->email_conductor,
            ];

            if ($request->filled('conductorPassword')) {
                $updateData['password'] = Hash::make($request->conductorPassword);
            }

            $vehiculo->update($updateData);

            return redirect()->route('admin.vehiculos.index')->with('success', 'Vehículo actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.vehiculos.index')
                ->with('error', 'El email ya está registrado por otro vehículo.');
        }
    }

    public function destroy($id)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $vehiculo = TransferVehiculo::findOrFail($id);
        $vehiculo->delete();

        return redirect()->route('admin.vehiculos.index')->with('success', 'Vehículo eliminado correctamente');
    }
}
