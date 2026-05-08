<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\TransporteController;
use App\Http\Controllers\HospedajeController;
use App\Http\Controllers\ViajeController;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [ViajeController::class, 'catalogo'])->name('home');
Route::get('paquetes', [ViajeController::class, 'catalogo'])->name('viajes.catalogo');
Route::get('paquetes/{viaje}', [ViajeController::class, 'catalogoShow'])->name('viajes.catalogo.show');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('reservaciones', [ReservacionController::class, 'index'])->name('reservaciones.index');
    Route::post('reservaciones', [ReservacionController::class, 'store'])->name('reservaciones.store');
    Route::get('reservaciones/{reservacion}', [ReservacionController::class, 'show'])->name('reservaciones.show');
    Route::patch('reservaciones/{reservacion}/cancelar', [ReservacionController::class, 'cancelar'])->name('reservaciones.cancelar');
    Route::get('reservaciones/{reservacion}/pdf', [ReservacionController::class, 'descargarTicket'])->name('reservaciones.pdf');
    Route::post('reservaciones/{reservacion}/email', [ReservacionController::class, 'enviarEmail'])->name('reservaciones.email');

    Route::middleware([AdminMiddleware::class])->group(function () { 
        Route::resource('destinos', DestinoController::class)->except(['index', 'show']);
        Route::resource('hospedajes', HospedajeController::class)->except(['index', 'show']);
        Route::resource('transportes', TransporteController::class);
        Route::resource('viajes', ViajeController::class);
        
        Route::get('usuarios/exportar', [UserController::class, 'exportar'])->name('usuarios.exportar');
        Route::post('usuarios/importar', [UserController::class, 'importar'])->name('usuarios.importar');
        Route::patch('usuarios/{usuario}/rol', [UserController::class, 'actualizarRol'])->name('usuarios.rol');
        Route::resource('usuarios', UserController::class)->only(['index', 'destroy']);
    });

    Route::resource('destinos', DestinoController::class)->only(['index', 'show']);
    Route::resource('hospedajes', HospedajeController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
