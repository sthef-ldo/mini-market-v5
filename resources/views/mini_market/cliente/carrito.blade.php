@extends('layouts.base_2')

@section('content')
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Num</flux:table.column>
            <flux:table.column>Producto</flux:table.column>
            <flux:table.column>Cantidad</flux:table.column>
            <flux:table.column>precio</flux:table.column>
            <flux:table.column>Agregado</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($productos->stocks as $producto)
                <flux:table.row>
                    <flux:table.cell>{{ $loop->iteration }}</flux:table.cell>
                    <flux:table.cell>{{ $producto->nombre }}</flux:table.cell>
                    <flux:table.cell>{{ $producto->pivot->cantidad }}</flux:table.cell>
                    <flux:table.cell>${{ $producto->precio }}</flux:table.cell>
                    <flux:table.cell>{{ $producto->created_at }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>

    </flux:table>
@endsection
