<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $rol = session('rol');
        $id = null;
        $user = null;

        switch ($rol) {
            case 'admin':
                $id = session('id_admin');
                $user = DB::table('transfer_admin')->where('id_admin', $id)->first();
                break;
            case 'cliente':
                $id = session('id_viajero');
                $user = DB::table('transfer_viajeros')->where('id_viajero', $id)->first();
                break;
            case 'hotel':
                $id = session('id_hotel');
                $user = DB::table('transfer_hotel')->where('id_hotel', $id)->first();
                break;
        }

        return view('profile.edit', compact('user', 'rol'));
    }

    public function update(Request $request)
    {
        $rol = session('rol');
        $id = null;
        $data = [];

        // Validación básica
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:4|confirmed',
        ]);

        switch ($rol) {
            case 'admin':
                $id = session('id_admin');
                $data = [
                    'nombre' => $request->nombre,
                    'email_admin' => $request->email,
                ];
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->password);
                }
                DB::table('transfer_admin')->where('id_admin', $id)->update($data);
                break;

            case 'cliente':
                $id = session('id_viajero');
                $data = [
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->password);
                }
                DB::table('transfer_viajeros')->where('id_viajero', $id)->update($data);
                break;

            case 'hotel':
                $id = session('id_hotel');
                $data = [
                    'nombre_hotel' => $request->nombre,
                    'email_hotel' => $request->email,
                ];
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->password);
                }
                DB::table('transfer_hotel')->where('id_hotel', $id)->update($data);
                break;
        }

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
