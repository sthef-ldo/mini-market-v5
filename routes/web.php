<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\VentataController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
    
// Rutas para categorías
Route::resource('/categorias', CategoriaController::class)
    ->except(['show', 'create', 'edit' ]); 

// Rutas para productos (stock)
route::resource('/stock', StockController::class);


// Rutas para mostrar el carrito
Route::get('/carrito/mostrar', [CarritoController::class, 'carrito'])
    ->name('carrito.mostrar')
    ->middleware('auth');  // ← Opcional: obliga login



// Rutas para carrito
route::resource('/catalogo', CatalogoController::class);


//prueba para agregar al carrito (funciona)
Route::post('/guardar-carrito', [CarritoController::class, 'guardar'])->name('carrito.guardar');
Route::delete('/carrito/eliminar/{stockId}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');



Route::post('/procesar-venta', [VentataController::class, 'procesarVenta'])
    ->name('ventas.procesar');




require __DIR__.'/settings.php';


