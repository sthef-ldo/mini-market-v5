@extends('layouts.base_2')

@section('content')
    <flux:heading size="lg" class="mb-6">Carrito de Compras</flux:heading>

    @if (session('error') || session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('error'))
                    alert(@json(session('error')));
                @elseif (session('success'))
                    alert(@json(session('success')));
                @endif
            });
        </script>
    @endif

    {{-- Tabla de productos --}}
    <flux:card class="flex flex-col gap-3 p-6 w-full ">
        <flux:table class="mb-10 w-full">
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>Producto</flux:table.column>
                <flux:table.column>Cantidad</flux:table.column>
                <flux:table.column>Precio</flux:table.column>
                <flux:table.column>Total</flux:table.column>
                <flux:table.column>Agregado</flux:table.column>
                <flux:table.column>Eliminar</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($carritos as $carrito)
                    @foreach ($carrito->stocks as $stock)
                        <flux:table.row>
                            <flux:table.cell>{{ $loop->iteration }}</flux:table.cell>
                            <flux:table.cell>{{ $stock->nombre }}</flux:table.cell>


                            <flux:table.cell>
                                <div class="position-relative">
                                    <span class="cantidad-display fw-bold me-3" data-stock-id="{{ $stock->id }}">
                                        {{ $stock->pivot->cantidad ?? 1 }}
                                    </span>

                                    <div class="actualizar-producto d-inline-flex items-center"
                                        data-stock-id="{{ $stock->id }}">
                                        @csrf
                                        <flux:button type="button" color="gray" size="sm" class="restar me-1">-
                                        </flux:button>
                                        <flux:button type="button" color="gray" size="sm" class="sumar">+
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:table.cell>




                            <flux:table.cell>${{ number_format($stock->precio, 2) }}</flux:table.cell>
                            <flux:table.cell class="sub-total" data-stock-id="{{ $stock->id }}">
                                ${{ number_format($stock->pivot->sub_total, 2) }}</flux:table.cell>
                            <flux:table.cell>{{ $stock->pivot->created_at->format('d/m/Y H:i') }}</flux:table.cell>

                            <flux:table.cell>
                                <form class="eliminar-producto" data-stock-id="{{ $stock->id }}"
                                    action="{{ route('carrito.eliminar', $stock->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <flux:button type="button" color="red" size="sm" class="btn-eliminar-producto">
                                        Eliminar
                                    </flux:button>
                                </form>
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                @endforeach
            </flux:table.rows>
        </flux:table>

        {{-- Resumen de compra --}}
        <div class="flex flex-col md:flex-row gap-8 items-center justify-between mt-8 mb-12">
            <flux:card class="flex flex-col gap-3 p-6 w-full md:w-1/2">
                <flux:text class="text-base">
                    <strong>Cantidad total de productos:</strong>
                    <span
                        id="cart-total-items">{{ $carritos->sum(fn($carrito) => $carrito->stocks->sum('pivot.cantidad')) }}</span>
                </flux:text>

                <flux:text class="text-base">
                    <strong>Total a pagar:</strong>
                    $<span
                        id="cart-total-price">{{ number_format($carritos->sum(fn($carrito) => $carrito->stocks->sum(fn($stock) => $stock->precio * $stock->pivot->cantidad)), 2) }}</span>
                </flux:text>
            </flux:card>

            <flux:card class="flex justify-center items-center p-6 w-full md:w-1/3">
                @if ($carritos->isEmpty())
                    <flux:button type="submit" color="green" class="w-full" disabled>Realizar Compra</flux:button>
                @else
                    <form action="{{ route('ventas.procesar') }}" method="POST"
                        onsubmit="return confirm('¿Deseas finalizar esta compra?');" class="w-full text-center">
                        @csrf
                        <flux:button type="submit" color="green" class="w-full">
                            Realizar Compra
                        </flux:button>
                    </form>
                @endif
            </flux:card>





        </div>
    </flux:card>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-eliminar-producto', function(e) {
                e.preventDefault();

                let form = $(this).closest('form');
                let actionUrl = form.attr('action');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Se eliminará este producto del carrito.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(response) {

                                Swal.fire(
                                    'Eliminado',
                                    response.message ??
                                    'Producto eliminado correctamente',
                                    'success'
                                );

                                // Eliminar la fila
                                form.closest('tr').remove();

                                // Si en tu respuesta devuelves totales, puedes actualizarlos aquí
                                // $('#cart-total-items').text(response.total_items);
                              
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error',
                                    'Error al eliminar el producto',
                                    'error'
                                );
                            }
                        });

                    }
                });
            });

        });
    </script>



    {{-- AJAX PARA AUMENTAR O DISMINUIR LA CANTIDAD DE UN PRODUCTO EN EL CARRITO --}}

    <script>
        $(document).on('click', '.actualizar-producto button.restar, .actualizar-producto button.sumar', function(e) {
            e.preventDefault();

            let $container = $(this).closest('.actualizar-producto');
            let stockId = $container.data('stock-id');
            let $cantidadDisplay = $('.cantidad-display[data-stock-id="' + stockId + '"]');
            let $subTotalCell = $('.sub-total[data-stock-id="' + stockId + '"]');
            let accion = $(this).hasClass('sumar') ? 'sumar' : 'restar';

            $.ajax({
                url: '{{ route('carrito.actualizar', ':id') }}'.replace(':id', stockId),
                type: 'POST',
                data: {
                    _token: $container.find('[name=_token]').val(),
                    accion: accion
                },
                dataType: 'json',
                success: function(response) {
                    if (response.removed) {
                        $container.closest('tr').remove();
                    } else {
                        $cantidadDisplay.text(response.cantidad);

                        if (response.sub_total !== undefined) {
                            $subTotalCell.text('$' + parseFloat(response.sub_total).toFixed(2));
                        }
                    }

                    if (response.total_items !== undefined) {
                        $('#cart-total-items').text(response.total_items);
                    }
                    if (response.total_price !== undefined) {
                        $('#cart-total-price').text(parseFloat(response.total_price).toFixed(2));
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON?.message);
                }
            });
        });
    </script>
@endsection




