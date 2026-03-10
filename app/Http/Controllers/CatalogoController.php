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

    public function buscar_producto(Request $request) {
        $query = $request->input('producto');
        $stocks = Stock::where('nombre', 'like', '%' . $query . '%')->get();
        return view('mini_market.cliente.buscar_producto', compact('stocks'));
    }

}
