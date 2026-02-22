@extends('layouts.base')

@section('content')
    <flux:card>
        <flux:heading size="lg">Detalle del Stock</flux:heading>

        {{-- Información organizada --}}
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre --}}
                <flux:description label="Nombre del Producto"> {{ $stock->nombre }} </flux:description>

                {{-- Cantidad --}}
                <flux:description label="Cantidad">  {{ $stock->cantidad }} ud </flux:description>

                {{-- Precio --}}
                <flux:description label="Precio"> ${{ number_format($stock->precio, 2) }} </flux:description>

                {{-- Categoría --}}
                <flux:description label="Categoría"> {{ $stock->categoria->nombre ?? 'Sin categoría' }} </flux:description>
            </div>

            {{-- Descripción --}}
            @if ($stock->descripcion)
                <flux:description label="Descripción"> {{ $stock->descripcion }} </flux:description>
            @endif
        </div>

        {{-- Botones de acción --}}
        <div class="flex gap-3 mt-8">
            <flux:button href="{{ route('stock.edit', $stock) }}" variant="primary">
                Editar
            </flux:button>
            <flux:button href="{{ route('stock.index') }}" variant="primary">
                Volver al listado
            </flux:button>
        </div>
    </flux:card>
@endsection
