<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CarritoController; 

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
    
// Rutas para categorías
Route::resource('/categorias', CategoriaController::class);

// Rutas para productos (stock)
route::resource('/stock', StockController::class);


// Rutas para mostrar el carrito
Route::get('/carrito/mostrar', [CarritoController::class, 'carrito'])
    ->name('carrito.mostrar')
    ->middleware('auth');  // ← Opcional: obliga login







     
// Rutas para carrito
route::resource('/carrito', CarritoController::class);





require __DIR__.'/settings.php';


