<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminReservaController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\HotelComisionController;



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

/* Redirección inicial */

Route::get('/', function () {
    return redirect()->route('welcome');
});

/* Vista de bienvenida */
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

/* Registro */
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

/* Login */
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta de bienvenida (para evitar error 404 al cerrar sesión o redirigir)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta para el editar los diferentes perfiles
Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/perfil/editar', [ProfileController::class, 'update'])->name('profile.update');


// ADMINISTRADOR
Route::get('/panel/admin', function () {
    return view('panel.admin');
})->name('admin.panel');

//Rutas para el calendario 
Route::get('/admin', function () {
    return view('panel.admin');
})->name('admin.panel');

Route::post('/admin/reserva/oneway', [AdminReservaController::class, 'storeOneWay'])->name('admin.reserva.oneway');
Route::post('/admin/reservas/return', [AdminReservaController::class, 'storeReturn'])->name('admin.reserva.return');
Route::post('/admin/reserva/roundtrip', [AdminReservaController::class, 'storeRoundTrip'])->name('admin.reserva.roundtrip');
Route::get('/admin/reserva/{id}', [AdminReservaController::class, 'show']);
Route::put('/admin/reserva/{id}', [AdminReservaController::class, 'update'])->name('admin.reserva.update');
Route::delete('/admin/reserva/{id}', [AdminReservaController::class, 'destroy'])->name('admin.reserva.destroy');
Route::get('/admin/lista-reservas', [AdminReservaController::class, 'list'])->name('admin.reservas.list');

Route::get('/admin/gestion-hoteles', [AdminHotelController::class, 'index'])->name('admin.hoteles.index'); // panel gestion de hoteles
Route::post('/admin/hotel', [AdminHotelController::class, 'store'])->name('admin.hotel.store'); // añade un hotel
Route::put('/admin/hotel/{id}', [AdminHotelController::class, 'update'])->name('admin.hotel.update'); // modifica un hotel
Route::delete('/admin/hotel/{id}', [AdminHotelController::class, 'destroy'])->name('admin.hotel.destroy'); // elimina un hotel

Route::get('/admin/gestion-vehiculos', [AdminCarController::class, 'index'])->name('admin.vehiculos.index'); // panel gestion de vehiculos
Route::post('/admin/vehiculo', [AdminCarController::class, 'store'])->name('admin.vehiculos.store'); // añade un vehiculo
Route::put('/admin/vehiculo/{id}', [AdminCarController::class, 'update'])->name('admin.vehiculos.update'); // modifica un vehiculo
Route::delete('/admin/vehiculo/{id}', [AdminCarController::class, 'destroy'])->name('admin.vehiculos.destroy'); // elimina un vehiculo


// CLIENTE
Route::get('/panel/customer', [CustomerController::class, 'panel'])
    ->middleware('viajero.auth')
    ->name('customer.panel');

/* Rutas de cliente particular */
Route::post('panel/customer/booking/oneway', [CustomerController::class, 'storeOneWay'])->name('booking.oneWay'); // añade reserva ida
Route::put('panel/customer/booking/update-one-way', [CustomerController::class, 'updateOneWay'])->name('booking.updateOneWay'); // modifica reserva ida
Route::delete('/booking/one-way/destroy/{id_reserva}', [CustomerController::class, 'destroyOneWay'])->name('booking.destroyOneWay'); // elimina reserva ida

Route::post('panel/customer/booking/return', [CustomerController::class, 'storeReturn'])->name('booking.return'); // añade reserva vuelta
Route::put('panel/customer/booking/update-return', [CustomerController::class, 'updateReturn'])->name('booking.updateReturn'); //modifica reserva vuelta
Route::delete('/booking/return/destroy/{id_reserva}', [CustomerController::class, 'destroyReturn'])->name('booking.destroyReturn'); // elimina reserva vuelta

Route::post('panel/customer/booking/roundtrip', [CustomerController::class, 'storeRoundTrip'])->name('booking.roundTrip'); // añade reserva ida-vuelta
Route::put('panel/customer/booking/update-round-trip', [CustomerController::class, 'updateRoundTrip'])->name('booking.updateRoundTrip'); //modifica reserva ida-vuelta
Route::delete('/booking/round-trip/destroy/{id_reserva}', [CustomerController::class, 'destroyRoundTrip'])->name('booking.destroyRoundTrip'); // elimina reserva ida-vuelta

Route::get('/panel/customer', [CustomerController::class, 'showBookingsByEmail'])->name('customer.panel'); // muestra las reservas filtradas por email



// HOTEL
Route::get('/panel/hotel', [HotelController::class, 'index'])->name('corp.panel'); // función inicial para obtener diferentes datos

Route::post('/hotel/reserva/oneway', [HotelController::class, 'storeOneWay'])->name('hotel.reserva.oneway'); // añade reserva ida
Route::post('/hotel/reserva/return', [HotelController::class, 'storeReturn'])->name('hotel.reserva.return'); // añade reserva vuelta
Route::post('/hotel/reserva/roundtrip', [HotelController::class, 'storeRoundTrip'])->name('hotel.reserva.roundtrip'); // añade reserva ida-vuelta
Route::put('/hotel/reserva/editar/ida', [HotelController::class, 'updateOneWay'])->name('hotel.update.oneway');//edita reserva de ida
Route::put('/hotel/reserva/editar/vuelta', [HotelController::class, 'updateReturn'])->name('hotel.update.return');//edita reserva de vuelta
Route::put('/hotel/reserva/editar/ida-vuelta', [HotelController::class, 'updateRoundTrip'])->name('hotel.update.roundtrip');//editar reserva ida-vuelta
Route::delete('/hotel/reserva/eliminar/{id}', [HotelController::class, 'destroy'])->name('hotel.reserva.destroy');//eliminar las reservas

Route::get('/hotel/comisiones', [HotelComisionController::class, 'verComisionesMensuales'])->name('hotel.comisiones'); //


Route::get('/admin/estadisticas-zonas', [AdminReservaController::class, 'estadisticasPorZona']);//Ver JSON

// Get para verificar conexión con BBDD de MySQL
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $databaseName = DB::connection()->getDatabaseName();
        return "✅ Conexión exitosa a MySQL. Base de datos: <strong>{$databaseName}</strong>";
    } catch (\Exception $e) {
        return "❌ Error de conexión: " . $e->getMessage();
    }
});
