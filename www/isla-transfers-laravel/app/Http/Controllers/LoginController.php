<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\TransferViajero;
use App\Models\TransferAdmin;
use App\Models\TransferHotel;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'inputEmail' => 'required|email',
            'inputPassword' => 'required|string',
            'user_type' => 'required|in:1,2,3',
        ]);

        $email = $request->inputEmail;
        $password = $request->inputPassword;
        $userType = $request->user_type;

        switch ($userType) {
            case "1": // Viajero
                $user = TransferViajero::where('email', $email)->first();
                if ($user && Hash::check($password, $user->password)) {
                    Session::put('email', $user->email);
                    Session::put('id_viajero', $user->id_viajero);
                    Session::put('rol', 'cliente');
                    return redirect()->route('customer.panel');
                }
                break;

            case "2": // Corporativo
                $user = TransferHotel::where('email_hotel', $email)->first();
                if ($user && Hash::check($password, $user->password)) {
                    Session::put('email', $user->email_hotel);
                    Session::put('id_hotel', $user->id_hotel);
                    Session::put('rol', 'hotel');
                    return redirect()->route('corp.panel');
                }
                break;

            case "3": // Administrador
                $user = TransferAdmin::where('email_admin', $email)->first();
                if ($user && Hash::check($password, $user->password)) {
                    Session::put('email', $user->email_admin);
                    Session::put('id_admin', $user->id_admin);
                    Session::put('rol', 'admin');
                    return redirect()->route('admin.panel');
                }
                break;
        }

        return back()->withErrors(['error' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}