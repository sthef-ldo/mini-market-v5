<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Stock;
use App\Models\Venta;

class DashboardController
{
    public function __invoke()
    {

        $cantidadUsers = User::count();

        $cantidadCategorias = Categoria::count();
        $categorias = Categoria::latest()->take(5)->get();

        $cantidadStocks = Stock::count();
        $stocks = Stock::latest()->take(5)->get();

        $cantidadVentas = Venta::count();
        $ventas = Venta::latest()->take(5)->get();

        return view('dashboard', compact('categorias', 'stocks', 'ventas', 'cantidadCategorias', 'cantidadStocks', 'cantidadVentas','cantidadUsers'));
    }
}
