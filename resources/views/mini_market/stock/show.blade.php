@extends('layouts.base')

@section('content')
    {{-- Breadcrumbs --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('stock.index') }}">Stock</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Detalles</flux:breadcrumbs.item>

    </flux:breadcrumbs>

     {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Detalles de Stock</flux:heading>
        </div>

    <flux:card>
        {{-- Información organizada --}}
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:description label="Nombre del Producto"> {{ $stock->nombre }} </flux:description>
                <flux:description label="Cantidad"> {{ $stock->cantidad }} ud </flux:description>
                <flux:description label="Precio"> ${{ number_format($stock->precio, 2) }} </flux:description>
                <flux:description label="Categoría"> {{ $stock->categoria->nombre ?? 'Sin categoría' }} </flux:description>
            </div>

            @if ($stock->descripcion)
                <flux:description label="Descripción"> {{ $stock->descripcion }} </flux:description>
            @endif
        </div>

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
