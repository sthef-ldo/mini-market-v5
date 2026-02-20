<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
    
// Rutas para categorías
Route::resource('/categorias', CategoriaController::class);

require __DIR__.'/settings.php';


