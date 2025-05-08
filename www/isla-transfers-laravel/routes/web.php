<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas sólo para particulares
    Route::middleware('role:particular')->group(function(){
        Route::get('/mis-reservas', /* … */)->name('reservas.particular');
        // añade aquí todas las rutas del panel de cliente particular
    });

    // Rutas sólo para corporativos
    Route::middleware('role:corporativo')->prefix('corporativo')->name('corporativo.')->group(function(){
        Route::get('/dashboard', /* … */)->name('dashboard');
        // rutas del panel de hotel/corporativo
    });

    // Rutas sólo para admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function(){
        Route::resource('reservas', App\Http\Controllers\Admin\ReservationController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });
    
});

require __DIR__.'/auth.php';
