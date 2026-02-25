<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Carrito;
use Illuminate\Support\Facades\DB;


class CarritoController extends Controller
{


    //mostrar datos del carrito funciona
    public function carrito() {
        $user = Auth::user();  // Automáticamente sabe quién eres
        $carritos = Carrito::with('stocks')->where('user_id', $user->id)->get();
        
        return view('mini_market.cliente.carrito', compact('carritos', 'user'));
    }


    public function guardar(Request $request){
        // Validar
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'stock_id' => 'required|exists:stocks,id',
        ]);

        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();


        //crea un carrito nuevo si no existe para el usuario
        if (!$carrito) {
            $carrito = Carrito::create([
                'user_id' => $user->id,
            ]);
        }

        $stockId = $request->stock_id;
        $cantidad = $request->cantidad;

        // existe el producto en el carrito? Si = sumamos cantidad. No = lo agrega como nuevo.
        $existe = $carrito->stocks()->where('stock_id', $stockId)->exists();

        if ($existe) {
            // sumar cantidad al producto existente
            $carrito->stocks()->updateExistingPivot($stockId, [
                'cantidad' => DB::raw('cantidad + ' . $cantidad)
            ]);
        } else {
            // agregar nuevo producto al carrito
            $carrito->stocks()->attach($stockId, [
                'cantidad' => $cantidad,
            ]);
        }

        return response()->json([
            'message' => 'Producto actualizado en carrito correctamente',
            'data'    => $request->all(),
            'unique_count' => $carrito->stocks()->count(), // cantidad de productos únicos en el carrito
            

        ]);
    }

    // eliminar un producto del carrito
    public function eliminar($stockId) {
        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();

        if ($carrito) {
            $carrito->stocks()->detach($stockId);
            return response()->json(['message' => 'Producto eliminado del carrito']);
        }

        return response()->json(['message' => 'Carrito no encontrado'], 404);
    }

}
