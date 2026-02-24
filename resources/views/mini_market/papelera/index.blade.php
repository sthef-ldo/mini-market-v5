@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Ventas Eliminadas</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Listado de ventas eliminadas</flux:heading>

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
                        @forelse ($ventasEliminadas as $ventaEliminada)
                            <flux:table.row>
                                <flux:table.cell>{{ $ventaEliminada->id }}</flux:table.cell>
                                <flux:table.cell>{{ $ventaEliminada->user->email }}</flux:table.cell>
                                <flux:table.cell>{{ $ventaEliminada->created_at }}</flux:table.cell>
                                <flux:table.cell>
                                    {{-- Ver detalles de la venta eliminada --}}
                                    <flux:button variant="primary" href="{{ route('papelera.show', $ventaEliminada->id) }}">
                                        Ver detalles
                                    </flux:button>

                                    {{-- RESTAURAR  la venta eliminada --}}
                                    <form action="{{ route('papelera.restaurar', $ventaEliminada->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <flux:button type="submit" class="btn btn-success">Restaurar venta</flux:button>
                                    </form>

                                    {{-- ELIMINAR POR COMPLETO la venta  --}}
                                    <form action="{{ route('papelera.destroy', $ventaEliminada->id) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar esta venta?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" class="btn btn-danger">Eliminar</flux:button>
                                    </form>

                                    {{-- usar soft delete --}}
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
