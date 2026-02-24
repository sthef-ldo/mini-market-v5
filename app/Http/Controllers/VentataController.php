<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Stock;
use App\Models\Venta;
use App\Models\VentaDetalle;

use Illuminate\Http\Request;

class VentataController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('mini_market.ventas.index', compact('ventas'));
    }

    public function show(Venta $venta)
    {
        $detalles =   VentaDetalle::where('venta_id', $venta->id)->get();
        return view('mini_market.ventas.show', compact('venta', 'detalles'));
    }



    public function procesarVenta(Request $request)
    {
        try {
            return DB::transaction(function () {
                $user = Auth::user();
                $carrito = DB::table('carritos')->where('user_id', $user->id)->first();

                if (!$carrito) {
                    throw new \Exception('No tienes un carrito activo.');
                }

                // Insertar venta
                $ventaId = DB::table('ventas')->insertGetId([
                    'user_id' => $carrito->user_id,
                    'estado' => 'completada',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $carritoItems = DB::table('carrito_stocks')->where('carrito_id', $carrito->id)->get();

                foreach ($carritoItems as $item) {
                    $stock = Stock::find($item->stock_id);

                    if ($stock->cantidad < $item->cantidad) {
                        throw new \Exception('No hay suficiente stock para: ' . $stock->nombre);
                    }

                    DB::table('venta_detalles')->insert([
                        'venta_id' => $ventaId,
                        'stock_id' => $item->stock_id,
                        'cantidad' => $item->cantidad,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Actualizar stock
                    $stock->cantidad -= $item->cantidad;
                    $stock->save();
                }

                // Eliminar carrito
                DB::table('carritos')->where('user_id', $user->id)->delete();

                return redirect()->route('carrito.mostrar')->with('success', 'Venta procesada exitosamente');
            });
        } catch (\Exception $e) {
            // Laravel hará rollback automático si hay excepción
            return redirect()->route('carrito.mostrar')->with('error', $e->getMessage());
        }
    }
}
