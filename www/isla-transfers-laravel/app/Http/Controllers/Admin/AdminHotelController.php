<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferHotel;
use App\Models\TransferZona;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminHotelController extends Controller
{
    public function index()
    {
        if (!Session::has('id_admin')) {
            return redirect()->route('login')->withErrors('Acceso no autorizado');
        }

        $hoteles = TransferHotel::all();
        $zonas = TransferZona::all();


        return view('panel.admin.hotel.adminHotel', compact('hoteles', 'zonas'));
    }

    public function store(Request $request)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $request->validate([
            'hotelName' => 'required|string|max:100',
            'zoneSelect' => 'required|exists:transfer_zona,id_zona',
            'hotelCommission' => 'required|numeric',
            'hotelEmail' => 'required|email',
            'hotelPassword' => 'required|string|min:4',
        ]);

        $comision = str_replace(',', '.', $request->hotelCommission);

        try {
            TransferHotel::create([
                'nombre_hotel' => $request->hotelName,
                'id_zona' => $request->zoneSelect,
                'comision' => floatval($comision),
                'email_hotel' => $request->hotelEmail,
                'password' => Hash::make($request->hotelPassword),
            ]);

            return redirect()->route('admin.hoteles.index')->with('success', 'Hotel registrado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.hoteles.index')
                ->with('error', 'El email del hotel ya está registrado en el sistema.');
        }
    }

    public function update(Request $request)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $hotel = TransferHotel::findOrFail($request->id_hotel);

        try {
            $request->validate([
                'hotelName' => 'required|string|max:100',
                'zoneSelect' => 'required|exists:transfer_zona,id_zona',
                'hotelCommission' => 'required|numeric',
                'hotelEmail' => 'required|email|unique:transfer_hotel,email_hotel,' . $hotel->id_hotel . ',id_hotel',
            ]);

            $comision = str_replace(',', '.', $request->hotelCommission);

            $updateData = [
                'nombre_hotel' => $request->hotelName,
                'id_zona' => $request->zoneSelect,
                'comision' => floatval($comision),
                'email_hotel' => $request->hotelEmail,
            ];

            if ($request->filled('hotelPassword')) {
                $updateData['password'] = Hash::make($request->hotelPassword);
            }

            $hotel->update($updateData);

            return redirect()->route('admin.hoteles.index')->with('success', 'Hotel actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.hoteles.index')
                ->with('error', 'El email ya está registrado por otro hotel.');
        }
    }

    public function destroy($id)
    {
        if (!Session::has('id_admin')) return redirect()->route('login');

        $hotel = TransferHotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('admin.hoteles.index')->with('success', 'Hotel eliminado correctamente');
    }
}
