<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirigir según rol
            switch (Auth::user()->rol) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'corporativo':
                    return redirect()->route('corporativo.dashboard');
                default:
                    return redirect()->route('reservas.index');
            }
        }

        return back()->withErrors([
            'email' => 'Email o contraseña incorrectos.'
        ]);
    }

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|confirmed|min:6',
            'nombre'   => 'nullable|string|max:100',
            'rol'      => 'required|in:particular,corporativo'
        ]);

        $user = User::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'nombre'   => $data['nombre'],
            'rol'      => $data['rol']
        ]);

        Auth::login($user);
        return redirect()->route('reservas.index');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
