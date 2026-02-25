<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock;

class CatalogoController extends Controller
{
     public function index(){
        $stocks = Stock::all();
        return view('mini_market.cliente.index', compact('stocks'));
    }

    public function show($stock) {
        $stock = Stock::findOrFail($stock);
        return view('mini_market.cliente.show', compact('stock'));
    }
}
