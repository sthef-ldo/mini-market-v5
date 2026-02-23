@extends('layouts.base')

@section('content')
    {{-- Breadcrumbs --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('stock.index') }}">Stock</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Detalles</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mt-6 mb-4">
        <flux:heading size="xl">Detalles de Stock</flux:heading>
    </div>

    <flux:card>
        {{-- Sección de Imagen --}}
        <div class="flex justify-center mb-8 p-4 bg-gray-50 rounded-xl">
            <div class="text-center">
                <div class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 bg-white rounded-xl shadow-lg border-2 border-gray-100 overflow-hidden mx-auto">
                    <img id="imgPreview" 
                         src="{{ $stock->imagen ? Storage::url($stock->imagen) : asset('images/sin-imagen.png') }}"
                         alt="Imagen del producto {{ $stock->nombre }}"
                         class="w-full h-full object-cover object-center transition-all duration-300 hover:scale-105">
                </div>
                <p class="mt-2 text-xs text-gray-500 font-medium">Vista previa del producto</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Datos Principales --}}
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:text label=""> Nombre del Producto: {{ $stock->nombre }} </flux:text>
                    <flux:text label="">Categoría: {{ $stock->categoria->nombre ?? 'Sin categoría' }} </flux:text>
                    <flux:text label="">Cantidad: {{ number_format($stock->cantidad) }} ud </flux:text>
                    <flux:text label=""> Precio: ${{ number_format($stock->precio, 2) }} </flux:text>
                </div>
            </div>

            {{-- Descripción --}}
            @if ($stock->descripcion)
                <div class="lg:col-span-2">
                    <flux:text label="">Descripción:</flux:text>
                    <flux:description label=""> {{ $stock->descripcion }} </flux:description>
                </div>
            @endif
        </div>

        {{-- Botones --}}
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
