<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Carrito;
use App\Models\Stock;


class CarritoController extends Controller
{


    //mostrar datos del carrito funciona
    public function carrito()
    {
        $user = Auth::user();  // Automáticamente sabe quién eres
        $carritos = Carrito::with('stocks')->where('user_id', $user->id)->get();

        return view('mini_market.cliente.carrito', compact('carritos', 'user'));
    }


    public function guardar(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'stock_id' => 'required|exists:stocks,id',
        ]);

        $user = Auth::user();
        $carrito = Carrito::firstOrCreate(['user_id' => $user->id]);
        $stockId = $request->stock_id;
        $cantidad = $request->cantidad;

        $stock = Stock::findOrFail($stockId);
        $subTotal = $stock->precio * $cantidad;

        // Si el producto ya existe en el carrito
        $existe = $carrito->stocks()->where('stock_id', $stockId)->first();

        if ($existe) {
            $nuevaCantidad = $existe->pivot->cantidad + $cantidad;
            $nuevoSubTotal = $stock->precio * $nuevaCantidad;

            $carrito->stocks()->updateExistingPivot($stockId, [
                'cantidad' => $nuevaCantidad,
                'sub_total' => $nuevoSubTotal,
            ]);
        } else {
            $carrito->stocks()->attach($stockId, [
                'cantidad' => $cantidad,
                'sub_total' => $subTotal,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito correctamente',
        ]);

        /* return response()->json([
            'message' => 'Producto actualizado en carrito correctamente',
        ]); */
    }


    // eliminar un producto del carrito
    public function eliminar($stockId)
    {
        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();

        if ($carrito) {
            $carrito->stocks()->detach($stockId);
            return response()->json(['message' => 'Producto eliminado del carrito']);
        }
        
        return response()->json(['message' => 'Carrito no encontrado'], 404);
    }






    //aumentar o disminuir la cantidad de un producto en el carrito con botones
   public function actualizarCarrito(Request $request, $stockId)
{
    $user = Auth::user();
    $carrito = Carrito::where('user_id', $user->id)->firstOrFail();

    $stock = Stock::findOrFail($stockId);
    $pivot = $carrito->stocks()->where('stock_id', $stockId)->firstOrFail();

    $cantidadActual = $pivot->pivot->cantidad;
    $accion = $request->input('accion');

    $nuevaCantidad = $accion === 'sumar'
        ? $cantidadActual + 1
        : $cantidadActual - 1;

    if ($nuevaCantidad <= 0) {
        $carrito->stocks()->detach($stockId);
        $totales = $this->recalcularTotales($carrito);

        return response()->json([
            'message'      => 'Producto eliminado',
            'removed'      => true,
            'cantidad'     => 0,
            'total_items'  => $totales['total_items'],
            'total_price'  => $totales['total_price'],
        ]);
    }

    $subTotal = $stock->precio * $nuevaCantidad;

    $carrito->stocks()->updateExistingPivot($stockId, [
        'cantidad'  => $nuevaCantidad,
        'sub_total' => $subTotal,
    ]);

    $totales = $this->recalcularTotales($carrito);

    return response()->json([
        'message'      => 'Cantidad actualizada',
        'cantidad'     => $nuevaCantidad,
        'sub_total'    => $subTotal,
        'total_items'  => $totales['total_items'],
        'total_price'  => $totales['total_price'],
        'removed'      => false,
    ]);
}





private function recalcularTotales(Carrito $carrito)
{
    $carrito->load('stocks');

    $totalItems = $carrito->stocks->sum('pivot.cantidad');
    $totalPrice = $carrito->stocks->map(function ($s) {
        return $s->precio * $s->pivot->cantidad;
    })->sum();

    return [
        'total_items' => $totalItems,
        'total_price' => $totalPrice,
    ];
}

}
