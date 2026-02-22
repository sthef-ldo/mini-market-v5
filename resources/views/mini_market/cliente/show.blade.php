@extends('layouts.base_2')

@section('content')
    <flux:card>
        <flux:heading size="lg">Detalle del Producto</flux:heading>

        <div class="space-y-6 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <flux:description label="Nombre del Producto"> {{ $stock->nombre }} </flux:description>
                <flux:description label="Precio"> ${{ $stock->precio }} </flux:description>
                <flux:description label="Stock disponible"> {{ $stock->cantidad }} ud </flux:description>
                <flux:description label="Categoría"> {{ $stock->categoria->nombre ?? 'Sin categoría' }} </flux:description>
            </div>

            @if ($stock->descripcion)
                <flux:description label="Descripción"> {{ $stock->descripcion }} </flux:description>
            @endif
        </div>

        {{-- Botones de acción --}}
        <div class="flex gap-3 mt-8">
            {{-- Botón para agregar al carrito (si aplica) --}}

            @if ($stock->cantidad > 0)

            {{-- prueba ajax --}}

                <flux:button variant="primary" disabled>Agregar al carrito</flux:button>
                
            @else
                <flux:button variant="primary" disabled>Agotado</flux:button>
            @endif

            {{-- Volver al listado de productos --}}
            <flux:button href="{{ route('carrito.index') }}" variant="primary"> Volver a productos</flux:button>


            {{-- Ir a la vista del carrito --}}
            <flux:button href="{{ route('carrito.mostrar') }}" variant="primary"> Ir al carrito </flux:button>

        </div>
    </flux:card>



{{--  prueba de ajax --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
