<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Categoria;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();

        return view('mini_market.stock.index', compact('stocks'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('mini_market.stock.create', compact('categorias'));
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
        ]);

        Stock::create($data);
        return redirect()->route('stock.index')->with('success', 'Stock creado exitosamente.');
    }



    public function show(Stock $stock) {
        return view('mini_market.stock.show', compact('stock'));
    }


    public function edit(Stock $stock)
    {
        $categorias = Categoria::all();
        return view('mini_market.stock.edit', compact('stock', 'categorias'));
    }

    public function update(Request $request, Stock $stock)
    {

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
        ]);

        $stock->update($data);
        return redirect()->route('stock.index')->with('success', 'Stock actualizado exitosamente.');
    }
    public function destroy(Stock $stock){
        $stock->delete();
        return redirect()->route('stock.index')->with('success', 'Stock eliminado exitosamente.');
    }
}
