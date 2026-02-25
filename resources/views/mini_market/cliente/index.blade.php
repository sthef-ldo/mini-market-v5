@extends('layouts.base_2')

@section('content')
    <flux:card class="max-w-7xl mx-auto">
        <flux:heading size="2xl" class="mb-8 text-center">Productos disponibles</flux:heading>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse ($stocks as $stock)
                <div
                    class="flux:card bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 border rounded-xl overflow-hidden">
                    <div class="p-6">

                        @if (empty($stock->imagen))
                            {{-- Sin Imagen --}}
                            <div
                                class="w-full h-48 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-gray-500 text-sm">🛒 Producto</span>
                            </div>
                        @else
                            {{-- Sin Imagen --}}
                            <div>
                                <img id="imgPreview"
                                    src="{{ $stock->imagen ? Storage::url($stock->imagen) : asset('images/sin-imagen.png') }}"
                                    alt="Imagen del producto {{ $stock->nombre }}"
                                    class="w-full h-full object-cover object-center transition-all duration-300 hover:scale-105">
                            </div>
                        @endif



                        {{-- Nombre --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">
                            {{ $stock->nombre }}
                        </h3>

                        {{-- Precio destacado --}}
                        <div class="mb-4">
                            <span class="text-2xl font-bold text-emerald-600">
                                ${{ number_format($stock->precio, 2) }}
                            </span>
                        </div>

                        {{-- Stock --}}
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-sm text-gray-600">
                                📦 {{ $stock->cantidad }} disponibles
                            </span>
                            @if ($stock->cantidad > 0)
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">
                                    En stock
                                </span>
                            @else
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">
                                    Agotado
                                </span>
                            @endif
                        </div>



                        {{-- Botón ver detalles --}}
                        <flux:button href="{{ route('catalogo.show', $stock->id) }}" variant="primary"
                            class="w-full font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 mt-2">
                            📄 Ver detalles
                        </flux:button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <flux:heading size="xl" class="text-gray-500 mb-4">No hay productos disponibles</flux:heading>
                </div>
            @endforelse
        </div>

    </flux:card>
@endsection
