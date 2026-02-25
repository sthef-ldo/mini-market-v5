@extends('layouts.base')

@section('content')


    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ventas.index') }}">Ventas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Detalles de Venta</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Detalles de Venta</flux:heading>
            
        </div>

    
        {{-- Tabla de categorías --}}
    
        <div>
            <flux:card class="space-y-6">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>ID</flux:table.column>
                    <flux:table.column>Producto</flux:table.column>
                    <flux:table.column>cantidad</flux:table.column>
                    <flux:table.column>Precio</flux:table.column>
                    <flux:table.column>Subtotal</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($detalles as $detalle)
                        <flux:table.row>
                            <flux:table.cell>{{ $detalle->id }}</flux:table.cell>
                            <flux:table.cell>{{ $detalle->stock->nombre }}</flux:table.cell>
                            <flux:table.cell>{{ $detalle->cantidad }}</flux:table.cell>
                            <flux:table.cell>{{ $detalle->precio }}</flux:table.cell>
                            <flux:table.cell>{{ $detalle->cantidad * $detalle->precio }}</flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center">
                                No hay ventas registradas
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
            </flux:card>
        </div>
    </div>
@endsection

