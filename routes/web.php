<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\VentataController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PapeleraController;

/* Route::get('/', function () {
    return view('welcome');
})->name('home'); 

/* Route::get('/', function () {
    return redirect()->route('catalogo.index');
});
 */

Route::get('/', [App\Http\Controllers\CatalogoController::class, 'index'])
    ->name('home');




//  ADMIN SOLO
Route::middleware(['auth', 'role:admin'])->group(function () {

    // DASHBOARD 
    Route::get('dashboard', DashboardController::class)
        ->name('dashboard');

    // CATEGORIAS 
    Route::resource('categorias', CategoriaController::class)
        ->except(['show', 'create', 'edit']); // Solo index, store, update, destroy

    //  STOCK  
    Route::resource('stock', StockController::class);

    // VENTAS
    Route::resource('/ventas', VentataController::class); // ← prueba asignado a admin

    // PAPELERA DE VENTAS ELIMINADAS
    Route::resource('/papelera', PapeleraController::class)
        ->except(['create', 'edit', 'store', 'update']); // Solo index, store, destroy
    //Ruta para restaurar venta eliminada
    Route::put('/{id}/restaurar', [PapeleraController::class, 'restaurar'])->name('papelera.restaurar');
});



//  CLIENTES - CATALOGO DE PRODUCTOS (público)
Route::resource('/catalogo', CatalogoController::class)
    ->only(['index', 'show']);

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



      // Prueba
      // Aumentar o disminuir la cantidad de un producto en el carrito con botones
    Route::post('/carrito/eliminar/{stockId}', [CarritoController::class, 'actualizarCarrito'])
        ->name('carrito.actualizar');
});














require __DIR__ . '/settings.php';
