<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\VentaDetalle;

class PapeleraController extends Controller
{
    public function index() {
        $ventasEliminadas = Venta::onlyTrashed()->get();
        return view('mini_market.papelera.index', compact('ventasEliminadas'));
    }

    public function show($venta){
        // Traer la venta eliminada (soft delete) con sus detalles eliminados
        $ventaEliminada = Venta::withTrashed()->findOrFail($venta);

        // Detalles eliminados asociados
        $detallesEliminados = $ventaEliminada->detalles()->onlyTrashed()->get();

        return view('mini_market.papelera.show', compact('ventaEliminada', 'detallesEliminados'));
    }

    //restaurar venta eliminada
    public function restaurar($venta){
        //venta general
        $ventaEliminada = Venta::withTrashed()->find($venta);
        $ventaEliminada->restore(); // quita el deleted_at

        // Restaurar todos los detalles asociados
        $ventaEliminada->detalles()->withTrashed()->restore();

        return redirect()
            ->route('papelera.index')
            ->with('success', 'Venta y sus detalles fueron restaurados correctamente.');
    }


    // Eliminar permanentemente la venta y sus detalles
    public function destroy($venta){
        $ventaEliminada = Venta::withTrashed()->findOrFail($venta);

        // Primero eliminar definitivamente los detalles
        $ventaEliminada->detalles()->withTrashed()->forceDelete();

        // Luego eliminar definitivamente la venta
        $ventaEliminada->forceDelete();

        return redirect()
            ->route('papelera.index')
            ->with('success', 'Venta y sus detalles eliminados permanentemente.');
    }
    
}
