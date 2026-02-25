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
        $users = User::count();
        $categorias = Categoria::count();
        $stocks = Stock::count();
        $ventas = Venta::count();

        $recent = Venta::with('user')->latest('created_at')->limit(6)->get();

        $latestCategorias = Categoria::latest('created_at')->limit(5)->get();
        $latestStocks = Stock::latest('created_at')->limit(5)->get();

        return view('dashboard', compact('users', 'categorias', 'stocks', 'ventas', 'recent', 'latestCategorias', 'latestStocks'));
    }
}
