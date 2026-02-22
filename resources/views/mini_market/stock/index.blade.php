@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Stock</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Boton redireccionar a crear nuevo stock --}}
    <div>
        <flux:button variant="primary" href="{{ route('stock.create') }}">Crear</flux:button>
    </div>

    <div name="tabla">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>id</flux:table.column>
                <flux:table.column>Nombre</flux:table.column>
                <flux:table.column>Cantidad</flux:table.column>
                <flux:table.column>Precio</flux:table.column>
                <flux:table.column>Categoria</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>


            <flux:table.rows>
                @forelse ($stocks as $stock)
                    <flux:table.row>
                        <flux:table.cell>{{ $stock->id }}</flux:table.cell>
                        <flux:table.cell>{{ $stock->nombre }}</flux:table.cell>
                        <flux:table.cell>{{ $stock->cantidad }}</flux:table.cell>
                        <flux:table.cell>{{ $stock->precio }}</flux:table.cell>
                        <flux:table.cell>{{ $stock->categoria->nombre }}</flux:table.cell>

                        <flux:table.cell>

                            {{-- Boton Show --}}
                            <flux:button icon="eye" href="{{ route('stock.show', $stock->id) }}">Ver</flux:button>

                            {{-- Boton Editar --}}
                            <flux:button icon="pencil" href="{{ route('stock.edit', $stock->id) }}">Editar</flux:button>

                            {{-- Boton Eliminar --}}
                            <form action="{{ route('stock.destroy', $stock->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                               <flux:button icon="trash" type="submit" color="destructive">Eliminar</flux:button> 
                            </form>

                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center">No hay categorías registradas</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>
@endsection
