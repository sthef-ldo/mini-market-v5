@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Stock</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Listado de Stock</flux:heading>
            <flux:button variant="primary" href="{{ route('stock.create') }}">
                Crear
            </flux:button>
        </div>

        {{-- Tabla de stock --}}
        <div>
            <flux:card class="space-y-6">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>ID</flux:table.column>
                        <flux:table.column>Nombre</flux:table.column>
                        <flux:table.column>Cantidad</flux:table.column>
                        <flux:table.column>Precio</flux:table.column>
                        <flux:table.column>Categoría</flux:table.column>
                        <flux:table.column>Acciones</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($stocks as $stock)
                            <flux:table.row>
                                <flux:table.cell>{{ $stock->id }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->nombre }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->cantidad }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->precio }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->categoria->nombre }}</flux:table.cell>

                                <flux:table.cell class="flex space-x-2">
                                    {{-- Botón Ver --}}
                                    <flux:button icon="eye" href="{{ route('stock.show', $stock->id) }}" size="sm">
                                        Ver
                                    </flux:button>

                                    {{-- Botón Editar --}}
                                    <flux:button icon="pencil" href="{{ route('stock.edit', $stock->id) }}" size="sm">
                                        Editar
                                    </flux:button>

                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" class="inline"  onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button icon="trash" type="submit" color="destructive" size="sm">
                                            Eliminar
                                        </flux:button>
                                    </form>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6" class="text-center">
                                    No hay registros de stock disponibles
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </div>
@endsection
