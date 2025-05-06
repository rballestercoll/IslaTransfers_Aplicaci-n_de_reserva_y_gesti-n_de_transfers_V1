<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit()
    {
        return view('perfil.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'email'    => 'required|email|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
            'nombre'   => 'nullable|string|max:100',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $user->email  = $data['email'];
        $user->nombre = $data['nombre'] ?? $user->nombre;
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('status', 'Perfil actualizado correctamente.');
    }
}
