@extends('layouts.base')

@section('content')
    <flux:card>

        <form action="{{ route('stock.update', $stock->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <flux:heading size="lg">Editar un nuevo stock</flux:heading>

            {{-- formulario --}}
            <div class="space-y-6">
                <flux:input label="Nombre del Producto" type="text" placeholder="ej:Arroz" name="nombre"
                    value="{{ $stock->nombre }}" required />
                <flux:input label="Cantidad" type="number" placeholder="ej:21" name="cantidad" value="{{ $stock->cantidad }}"
                    required />
                <flux:input label="Precio" type="number" placeholder="ej:29.99" name="precio" value="{{ $stock->precio }}"
                    required />

                {{-- Selector de categorias --}}
                <flux:select label="Categoria" wire:model="industry" name="categoria_id">
                    @foreach ($categorias as $categoria)
                        <flux:select.option value="{{ $categoria->id }}" :selected="$categoria->id == old('categoria_id', $stock->categoria_id)">
                            {{ $categoria->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>


                {{-- Descripcion del elemento --}}
                <flux:textarea name="descripcion" rows="auto" label="Descripcion"
                    placeholder="No lettuce, tomato, or onion...">{{ $stock->descripcion }}</flux:textarea>
            </div>

            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </form>
    </flux:card>
@endsection
