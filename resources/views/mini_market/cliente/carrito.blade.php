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
                            <flux:table.cell>{{ $stock->pivot->cantidad }}</flux:table.cell>
                            <flux:table.cell>${{ number_format($stock->precio, 2) }}</flux:table.cell>
                            <flux:table.cell>${{ number_format($stock->pivot->sub_total, 2) }}</flux:table.cell>
                            <flux:table.cell>{{ $stock->pivot->created_at->format('d/m/Y H:i') }}</flux:table.cell>

                            <flux:table.cell>
                                <form class="eliminar-producto" data-stock-id="{{ $stock->id }}"
                                    action="{{ route('carrito.eliminar', $stock->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" color="red" size="sm">Eliminar</flux:button>
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
                    {{ $carritos->sum(fn($carrito) => $carrito->stocks->sum('pivot.cantidad')) }}
                </flux:text>

                <flux:text class="text-base">
                    <strong>Total a pagar:</strong>
                    ${{ number_format($carritos->sum(fn($carrito) => $carrito->stocks->sum(fn($stock) => $stock->precio * $stock->pivot->cantidad)), 2) }}
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
            $('.eliminar-producto').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let actionUrl = form.attr('action');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        form.closest('tr').remove();
                    },
                    error: function(xhr) {
                        alert('Error al eliminar el producto');
                    }
                });
            });
        });
    </script>
@endsection
