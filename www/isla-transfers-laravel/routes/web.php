<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CorporativoController;

// Página de bienvenida
Route::get('/', fn() => view('welcome'))->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register',[AuthController::class, 'register']);
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (usuario autenticado)
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('perfil',   [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::patch('perfil', [PerfilController::class, 'update'])->name('perfil.update');

    // Rutas usuario particular
    Route::middleware('role:particular')->group(function () {
        Route::resource('reservas', ReservaController::class)
             ->except(['edit','update','destroy']); 
        // añadir aquí las rutas editar/cancelar particulares si lo deseas
    });

    // Rutas corporativo
    Route::middleware('role:corporativo')->prefix('corporativo')->group(function () {
        Route::get('dashboard', [CorporativoController::class,'dashboard'])
             ->name('corporativo.dashboard');
        // Rutas para que el hotel corporativo haga reservas, vea comisiones, etc.
    });

    // Rutas admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('dashboard', [AdminController::class,'dashboard'])
             ->name('admin.dashboard');
        Route::resource('reservas', AdminController::class)
             ->except(['show']); 
        // Ajusta los métodos necesarios en AdminController
    });
});
