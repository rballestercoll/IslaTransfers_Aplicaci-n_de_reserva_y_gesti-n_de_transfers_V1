<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckCustomerSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('id_viajero')) {
            return redirect()->route('login')->withErrors(['error' => 'Acceso no autorizado.']);
        }

        return $next($request);
    }
}
