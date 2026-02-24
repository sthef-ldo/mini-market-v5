@extends('layouts.base_2')

@section('content')
    <flux:card>
        <flux:heading size="lg" class="mb-6 text-center">Detalle del Producto</flux:heading>

        {{-- Sección de Imagen --}}
        <div class="flex justify-center mb-8 bg-gray-50 rounded-xl p-6">
            <div class="text-center">
                <div
                    class="w-40 h-40 lg:w-48 lg:h-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mx-auto">
                    <img id="imgPreview"
                        src="{{ $stock->imagen ? Storage::url($stock->imagen) : asset('images/sin-imagen.png') }}"
                        alt="Imagen del producto {{ $stock->nombre }}"
                        class="w-full h-full object-cover object-center transition-all duration-300 hover:scale-105">
                </div>
                <p class="mt-3 text-sm text-gray-500 font-medium">Vista previa del producto</p>
            </div>
        </div>

        {{-- Detalles del producto --}}
        <div class="space-y-6 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <flux:description label="">Nombre del Producto: {{ $stock->nombre }} </flux:description>
                <flux:description label="">Precio: ${{ $stock->precio }} </flux:description>
                <flux:description label="">Stock disponible: {{ $stock->cantidad }} ud </flux:description>
                <flux:description label="Categoría">Categoría: {{ $stock->categoria->nombre ?? 'Sin categoría' }}
                </flux:description>
            </div>

            @if ($stock->descripcion)
                <div class="border-t pt-4">
                    <flux:description label="">Descripción: {{ $stock->descripcion }} </flux:description>
                </div>
            @endif
        </div>

        {{-- Botones y formulario --}}
        <div class="mt-10 border-t pt-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">

                {{-- Formulario de cantidad --}}
                @if ($stock->cantidad > 0 )
                    <form id="form-user" class="flex items-end gap-4">
                        @csrf
                        <div class="w-32">
                            <flux:input type="text" name="cantidad" id="cantidad" label="Cantidad" />
                        </div>
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <flux:button variant="primary" type="submit">Guardar</flux:button>
                    </form>
                @else
                    <flux:button variant="primary" disabled>Agotado</flux:button>
                @endif

                {{-- Navegación --}}
                <div class="flex flex-wrap justify-center md:justify-end gap-3">
                    <flux:button href="{{ route('catalogo.index') }}" variant="primary">Volver a productos</flux:button>
                    <flux:button href="{{ route('carrito.mostrar') }}" variant="primary">Ir al carrito</flux:button>
                </div>
            </div>

            {{-- Mensajes --}}
            <div class="mt-4 text-sm">
                <div id="errors" class="text-red-600"></div>
                <div id="success" class="text-green-600"></div>
            </div>
        </div>
    </flux:card>

    {{-- Script AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#form-user').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: '{{ route('carrito.guardar') }}',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#success').text(response.message);
                        $('#errors').empty();

                        // Actualizar contador en el layout
                        if (response.unique_count !== undefined) {
                            $('#cart-count').text(response.unique_count);
                        }
                        /* console.log(response.user); */
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let html = '<ul>';
                            $.each(errors, function(key, value) {
                                html += '<li>' + value[0] + '</li>';
                            });
                            html += '</ul>';
                            $('#errors').html(html);
                        } else {
                            console.log('Error inesperado');
                        }
                    }
                });
            });
        });
    </script>
@endsection
