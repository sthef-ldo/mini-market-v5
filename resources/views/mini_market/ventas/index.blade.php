@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Ventas de Productos</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Listado de ventas</flux:heading>

            <flux:button href="{{ route('papelera.index') }}" class="btn btn-danger">Papelera de Venta</flux:button>

        </div>


        {{-- Tabla de categorías --}}

        <div>
            <flux:card class="space-y-6">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>ID</flux:table.column>
                        <flux:table.column>Usuario</flux:table.column>
                        <flux:table.column>Fecha</flux:table.column>
                        <flux:table.column>Detalles</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($ventas as $venta)
                            <flux:table.row>
                                <flux:table.cell>{{ $venta->id }}</flux:table.cell>
                                <flux:table.cell>{{ $venta->user->email }}</flux:table.cell>
                                <flux:table.cell>{{ $venta->created_at }}</flux:table.cell>
                                <flux:table.cell>
                                    <div class="flex items-center gap-2">
                                        {{-- Botón para ver detalles de la venta --}}
                                        <flux:button variant="primary" href="{{ route('ventas.show', $venta->id) }}">
                                            Ver detalles
                                        </flux:button>
                                        {{-- Botón para softdelete venta  --}}
                                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" class="btn btn-danger">
                                                Eliminar
                                            </flux:button>
                                        </form>
                                    </div>
                                </flux:table.cell>
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
