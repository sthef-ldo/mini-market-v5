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
            <div class="card-stat">
                <div class="text-sm text-neutral-500">Usuarios</div>
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $users }}</div>
            </div>

            <div class="card-stat">
                <div class="text-sm text-neutral-500">Categorías</div>
                <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $categorias }}</div>
            </div>

            <div class="card-stat">
                <div class="text-sm text-neutral-500">Stocks</div>
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stocks }}</div>
            </div>

            <div class="card-stat">
                <div class="text-sm text-neutral-500">Ventas</div>
                <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $ventas }}</div>
            </div>
        </div>
    </div>

    <!-- Tabla de últimas ventas -->
    <div class="card-table">
        <h2 class="text-lg font-medium mb-4 text-neutral-800 dark:text-neutral-100">Últimas ventas</h2>

        @if(empty($recent) || $recent->isEmpty())
            <div class="text-sm text-neutral-500">No hay ventas recientes.</div>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm">
                    <thead class="bg-neutral-100 dark:bg-neutral-700 text-neutral-500 uppercase text-xs">
                        <tr>
                            <th class="text-left py-2 px-3">ID</th>
                            <th class="text-left py-2 px-3">Usuario</th>
                            <th class="text-left py-2 px-3">Total</th>
                            <th class="text-left py-2 px-3">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent as $v)
                            <tr class="border-t border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                                <td class="py-2 px-3">{{ $v->id }}</td>
                                <td class="py-2 px-3">{{ $v->user?->name ?? '—' }}</td>
                                <td class="py-2 px-3 font-semibold text-green-600 dark:text-green-400">{{ number_format($v->total ?? 0, 2) }}</td>
                                <td class="py-2 px-3">{{ $v->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Tabla de últimas categorías y productos -->
    <div class="card-table">
        <h2 class="text-lg font-medium mb-4 text-neutral-800 dark:text-neutral-100">Últimas categorías y productos</h2>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm">
                <thead class="bg-neutral-100 dark:bg-neutral-700 text-neutral-500 uppercase text-xs">
                    <tr>
                        <th class="text-left py-2 px-3">Tipo</th>
                        <th class="text-left py-2 px-3">Nombre</th>
                        <th class="text-left py-2 px-3">Detalle</th>
                        <th class="text-left py-2 px-3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestCategorias as $cat)
                        <tr class="border-t border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                            <td class="py-2 px-3 text-blue-600 dark:text-blue-400 font-medium">Categoría</td>
                            <td class="py-2 px-3">{{ $cat->nombre }}</td>
                            <td class="py-2 px-3">—</td>
                            <td class="py-2 px-3">{{ $cat->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="py-2 px-3" colspan="4">No hay categorías recientes.</td>
                        </tr>
                    @endforelse

                    @forelse($latestStocks as $s)
                        <tr class="border-t border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition">
                            <td class="py-2 px-3 text-yellow-600 dark:text-yellow-400 font-medium">Producto</td>
                            <td class="py-2 px-3">{{ $s->nombre }}</td>
                            <td class="py-2 px-3">
                                Precio: {{ number_format($s->precio ?? 0, 2) }} —
                                Cant: {{ $s->cantidad ?? 0 }}
                            </td>
                            <td class="py-2 px-3">{{ $s->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="py-2 px-3" colspan="4">No hay productos recientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
@push('styles')
<style>
.card-stat {
    @apply bg-white dark:bg-neutral-800 shadow-md rounded-lg p-5 transition hover:shadow-lg border border-neutral-200 dark:border-neutral-700;
}
.card-table {
    @apply bg-white dark:bg-neutral-800 shadow-md rounded-lg p-6 border border-neutral-200 dark:border-neutral-700;
}
</style>
@endpush
@endsection
