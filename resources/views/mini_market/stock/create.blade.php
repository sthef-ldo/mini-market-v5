@extends('layouts.base')

@section('content')
    <flux:card>

        <form action="{{ route('stock.store') }}" method="POST">
            @csrf

            <flux:heading size="lg">Crear un nuevo stock</flux:heading>

            {{-- formulario --}}
            <div class="space-y-6">
                <flux:input label="Nombre del Producto" type="text" placeholder="ej:Arroz" name="nombre" required />
                <flux:input label="Cantidad" type="number" placeholder="ej:21" name="cantidad" required />
                <flux:input label="Precio" type="number" placeholder="ej:29.99" name="precio" required />

                {{-- Selector de categorias --}}
                <flux:select name="categoria_id" placeholder="selecionar una...">
                    @forelse ($categorias as $categoria)
                        <flux:select.option value="{{ $categoria->id }}">
                            {{ $categoria->nombre }}
                        </flux:select.option>
                    @empty
                        <p>No hay categorías disponibles</p>
                    @endforelse
                </flux:select>


                {{-- Descripcion del elemento --}}
                <flux:textarea name="descripcion" rows="auto" label="Order notes"
                    placeholder="No lettuce, tomato, or onion..." />
            </div>

            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </form>
    </flux:card>
@endsection
