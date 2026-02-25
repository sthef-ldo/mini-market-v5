<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index() {
        $categorias = Categoria::all();
        return view('mini_market.categoria.index', compact('categorias'));
    }

    public function store(Request $request){

        $data = $request->validate([
            'nombre' => 'required|unique:categorias,nombre',
        ]);

        Categoria::create($data);
        return redirect()->route('categorias.index');
    }

    public function update(Request $request, Categoria $categoria){

        $data = $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id,
        ]);

        $categoria->update($data);
        return redirect()->route('categorias.index');
    }

    public function destroy(Categoria $categoria){
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
