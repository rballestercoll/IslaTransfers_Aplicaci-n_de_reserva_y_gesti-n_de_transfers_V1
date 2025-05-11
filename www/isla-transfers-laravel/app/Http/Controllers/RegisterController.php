<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferViajero;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'required|string|max:100',
            'direccion' => 'required|string|max:100',
            'codigoPostal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'email' => 'required|email|unique:transfer_viajeros,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        TransferViajero::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'direccion' => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'ciudad' => $request->ciudad,
            'pais' => $request->pais,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente');
    }
}