<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Carrito;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('mini_market.cliente.index', compact('stocks'));
    }

    public function show($stock)
    {
        $stock = Stock::findOrFail($stock);
        return view('mini_market.cliente.show', compact('stock'));
    }

    //mostrar datos del carrito funciona
    public function carrito()
    {
        $user = Auth::user();  // Automáticamente sabe quién eres
        $productos = Carrito::with('stocks')
            ->where('user_id', $user->id)  // Filtra por TU user_id
            ->first();
        return view('mini_market.cliente.carrito', compact('productos', 'user'));
    }



    public function guardar(Request $request)
    {
        // Validar
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'stock_id' => 'required|exists:stocks,id',
        ]);

        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();

        if (!$carrito) {
            $carrito = Carrito::create([
                'user_id' => $user->id,
            ]);
        }

        // Agregar el producto al carrito
        $carrito->stocks()->attach($request->stock_id, [
            'cantidad' => $request->cantidad,
        ]);

        return response()->json([
            'message' => 'Producto agregado al carrito correctamente',
            'data'    => $request->all(),
        ]);
    }
}
