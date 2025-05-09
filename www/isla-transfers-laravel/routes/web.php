<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminReservaController;
use App\Http\Controllers\AdminHotelController;
use App\Http\Controllers\AdminZonaController;
use App\Http\Controllers\AdminViajeroController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login / Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Redirige a dashboard general
    Route::get('/dashboard', function () {
        \Log::info('Entrando a /dashboard con usuario: ' . auth()->user()->email);

        if (Auth::user()->rol === 'admin') {
            return redirect('/admin');
        }

        return view('dashboard'); // Para usuarios no admin
    });

    // Panel de administración
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        });

        // Reservas
        Route::get('/reservas', [AdminReservaController::class, 'index']);
        Route::get('/reservas/{id}', [AdminReservaController::class, 'show']);
        Route::get('/reservas/{id}/edit', [AdminReservaController::class, 'edit']);
        Route::put('/reservas/{id}', [AdminReservaController::class, 'update']);
        Route::delete('/reservas/{id}', [AdminReservaController::class, 'destroy']);

        // NUEVAS RUTAS PARA VIAJEROS
        Route::get('/reservas/{reserva}/viajeros/create', [AdminViajeroController::class, 'create']);
        Route::post('/reservas/{reserva}/viajeros', [AdminViajeroController::class, 'store']);

        // Hoteles y zonas
        Route::get('/hoteles', [AdminHotelController::class, 'index']);
        Route::get('/hoteles/{id}/edit', [AdminHotelController::class, 'edit']);
        Route::put('/hoteles/{id}', [AdminHotelController::class, 'update']);
        Route::get('/hoteles/{id}/comisiones', [App\Http\Controllers\AdminHotelController::class, 'comisiones']);
        Route::get('/zonas', [AdminZonaController::class, 'index']);
        Route::get('/zonas/{id}/edit', [AdminZonaController::class, 'edit']);
        Route::put('/zonas/{id}', [AdminZonaController::class, 'update']);

    });

});
