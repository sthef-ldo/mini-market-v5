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

    //soft delete de venta y detalles
    public function destroy($id)
    {

        $venta = Venta::findOrFail($id);

        // Eliminar (soft delete) los detalles 
        $venta->detalles()->get()->each(function ($detalle) {
            $detalle->delete();
        });

        //  eliminar la venta
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }



    public function procesarVenta(Request $request)
    {
        try {
            // Si algo falla, Laravel reverte ("rollback") todos los cambios.
            return DB::transaction(function () {

                $user = Auth::user();
                $carrito = DB::table('carritos')->where('user_id', $user->id)->first();

                // Verificar que el usuario tenga un carrito
                if (!$carrito) {
                    throw new \Exception('No tienes un carrito activo.');
                }

                // Inserta los datos de carrito a ventas y obtiene el ID de la venta recién creada.
                $ventaId = DB::table('ventas')->insertGetId([
                    'user_id' => $carrito->user_id,
                    'estado' => 'completada',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Obtener todos los productos asociados al carrito actual.
                $carritoItems = DB::table('carrito_stocks')
                    ->where('carrito_id', $carrito->id)
                    ->get();

                // Recorrer los items del carrito uno por uno.
                foreach ($carritoItems as $item) {

                    // Buscar el producto (stock) en el inventario.
                    $stock = Stock::find($item->stock_id);

                    // Verificar que haya suficiente stock para la cantidad solicitada.
                    if ($stock->cantidad < $item->cantidad) {
                        // Si no hay suficiente, lanzamos una excepción para detener la venta.
                        throw new \Exception('No hay suficiente stock para: ' . $stock->nombre);
                    }

                    // Insertar el detalle de la venta (producto, cantidad, etc.)
                    DB::table('venta_detalles')->insert([
                        'venta_id' => $ventaId,
                        'stock_id' => $item->stock_id,
                        'cantidad' => $item->cantidad,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    //  Actualizar la cantidad disponible en el inventario (restar lo vendido).
                    $stock->cantidad -= $item->cantidad;
                    $stock->save();
                }

                // Finalmente, eliminar el carrito del usuario (ya se procesó la compra).
                DB::table('carritos')->where('user_id', $user->id)->delete();

                // Redirigir al usuario con un mensaje de éxito.
                return redirect()
                    ->route('carrito.mostrar')
                    ->with('success', 'Venta procesada exitosamente');
            });
            
        } catch (\Exception $e) {
            // Si ocurre cualquier error, Laravel revertirá la transacción automáticamente.
            // Mostramos el mensaje de error al usuario.
            return redirect()
                ->route('carrito.mostrar')
                ->with('error', $e->getMessage());
        }
    }
}
