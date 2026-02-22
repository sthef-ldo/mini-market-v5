@extends('layouts.base_2')

@section('content')
    <flux:card>
        <flux:heading size="lg">Detalle del Producto</flux:heading>

        <div class="space-y-6 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <flux:description label="Nombre del Producto"> {{ $stock->nombre }} </flux:description>
                <flux:description label="Precio"> ${{ $stock->precio }} </flux:description>
                <flux:description label="Stock disponible"> {{ $stock->cantidad }} ud </flux:description>
                <flux:description label="Categoría"> {{ $stock->categoria->nombre ?? 'Sin categoría' }} </flux:description>
            </div>

            @if ($stock->descripcion)
                <flux:description label="Descripción"> {{ $stock->descripcion }} </flux:description>
            @endif
        </div>

        {{-- Botones de acción --}}
        <div class="flex gap-3 mt-8">
            {{-- Botón para agregar al carrito (si aplica) --}}

            @if ($stock->cantidad > 0)
                {{-- prueba ajax --}}

                <form id="form-user">
                    @csrf
                     <flux:input type="text" name="cantidad" id="cantidad" label="Cantidad"/>
                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                    <flux:button variant="primary" type="submit" >Guardar</flux:button>
                
                </form>
                <div id="errors"></div>
                <div id="success"></div>


                {{-- prueba ajax --}}
            @else
                <flux:button variant="primary" disabled>Agotado</flux:button>
            @endif

            {{-- Volver al listado de productos --}}
            <flux:button href="{{ route('catalogo.index') }}" variant="primary"> Volver a productos</flux:button>


            {{-- Ir a la vista del carrito --}}
            <flux:button href="{{ route('carrito.mostrar') }}" variant="primary"> Ir al carrito </flux:button>

        </div>
    </flux:card>



    {{--  prueba de ajax --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('#form-user').on('submit', function (e) {
        e.preventDefault(); // evita el envío normal

        let form = $(this);

        $.ajax({
            url:  '{{ route("carrito.guardar") }}', // Blade imprime la ruta
            type: 'POST',
            data: form.serialize(), // incluye _token y todos los campos
            dataType: 'json',
            success: function (response) {
                $('#success').text(response.message);
                $('#errors').empty();
                console.log(response.user);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Errores de validación
                    let errors = xhr.responseJSON.errors;
                    let html = '<ul>';
                    $.each(errors, function (key, value) {
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
