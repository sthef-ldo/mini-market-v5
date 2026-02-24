<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\VentataController;

use App\Http\Controllers\PapeleraController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard público (cualquiera puede ver)
 Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');




//  ADMIN SOLO
Route::middleware(['auth', 'role:admin'])->group(function () {
/*     Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
     */
    // CATEGORIAS 
    Route::resource('categorias', CategoriaController::class)
        ->except(['show']); // Solo index, store, update, destroy
    
    //  STOCK  
    Route::resource('stock', StockController::class);
});



//  CLIENTES
Route::resource('/catalogo', CatalogoController::class); // ← Público

// Carrito (requiere login)
Route::middleware('auth')->group(function () {
    Route::get('/carrito/mostrar', [CarritoController::class, 'carrito'])
        ->name('carrito.mostrar');
    
    Route::post('/guardar-carrito', [CarritoController::class, 'guardar'])
        ->name('carrito.guardar');
    
    Route::delete('/carrito/eliminar/{stockId}', [CarritoController::class, 'eliminar'])
        ->name('carrito.eliminar');

    // Procesar venta  
    Route::post('/procesar-venta', [VentataController::class, 'procesarVenta'])
    ->name('ventas.procesar');
});




Route::resource('/ventas', VentataController::class); // ← prueba asignado a admin
Route::resource('/papelera', PapeleraController::class); // ← prueba asignado a admin
Route::put('/{id}/restaurar', [PapeleraController::class, 'restaurar'])->name('papelera.restaurar');

require __DIR__.'/settings.php';
