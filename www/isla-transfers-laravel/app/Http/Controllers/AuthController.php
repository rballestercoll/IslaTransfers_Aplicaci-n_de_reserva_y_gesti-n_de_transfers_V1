<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario directamente
        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!$usuario) {
            \Log::error('Usuario no encontrado: ' . $credentials['email']);
            return back()->withErrors(['email' => 'Usuario no encontrado']);
        }

        if (!Hash::check($credentials['password'], $usuario->password)) {
            \Log::error('Contraseña incorrecta para: ' . $credentials['email']);
            return back()->withErrors(['email' => 'Contraseña incorrecta']);
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        \Log::info('Login exitoso: ' . $usuario->email);

        if ($usuario->rol === 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
