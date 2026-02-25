@extends('layouts.base')

@section('content')
    <div class="p-6 space-y-8">
        <!-- Título principal -->
        <div>
            <h1 class="text-3xl font-semibold mb-6 text-neutral-800 dark:text-neutral-100">
                Panel de control
            </h1>

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <flux:card class="space-y-6">
                    <div class="text-sm">Usuarios</div>
                    <div class="text-3xl font-bold">{{ $cantidadUsers }}</div>
                </flux:card>

                <flux:card class="space-y-6">
                    <div class="text-sm">Categorías</div>
                    <div class="text-3xl font-bold">{{ $cantidadCategorias }}</div>
                </flux:card>

                <flux:card class="space-y-6">
                    <div class="text-sm">Stocks</div>
                    <div class="text-3xl font-bold">{{ $cantidadStocks }}</div>
                </flux:card>

                <flux:card class="space-y-6">
                    <div class="text-sm">Ventas</div>
                    <div class="text-3xl font-bold">{{ $cantidadVentas }}</div>
                </flux:card>
            </div>
        </div>

        {{-- tabla ventas --}}
        <div>
            <div class="flex items-center justify-between mt-6 mb-4">
                <flux:heading size="xl">Listado de Categorías</flux:heading>
            </div>

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

        {{-- tabla categorias  --}}
        <div>
            <div class="flex items-center justify-between mt-6 mb-4">
                <flux:heading size="xl">Listado de Categorías</flux:heading>
            </div>

            <flux:card class="space-y-6">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>ID</flux:table.column>
                        <flux:table.column>Nombre</flux:table.column>
                        <flux:table.column>Asignados</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($categorias as $categoria)
                            <flux:table.row>
                                <flux:table.cell>{{ $categoria->id }}</flux:table.cell>
                                <flux:table.cell>{{ $categoria->nombre }}</flux:table.cell>
                                <flux:table.cell>{{ $categoria->stocks()->count() }}</flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="4" class="text-center">
                                    No hay categorías registradas
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        {{-- tabla stocks --}}
        <div>
            <div class="flex items-center justify-between mt-6 mb-4">
                <flux:heading size="xl">Listado de Stocks</flux:heading>
            </div>

            <flux:card class="space-y-6">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>ID</flux:table.column>
                        <flux:table.column>Nombre</flux:table.column>
                        <flux:table.column>Cantidad</flux:table.column>
                        <flux:table.column>Precio</flux:table.column>
                        <flux:table.column>Categoría</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($stocks as $stock)
                            <flux:table.row>
                                <flux:table.cell>{{ $stock->id }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->nombre }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->cantidad }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->precio }}</flux:table.cell>
                                <flux:table.cell>{{ $stock->categoria->nombre }}</flux:table.cell>
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
    @endsection
