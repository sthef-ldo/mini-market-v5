@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Categorias</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div name="tabla">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>id</flux:table.column>
                <flux:table.column>Nombre</flux:table.column>
                <flux:table.column>Asignados</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>


            <flux:table.rows>
                @forelse ($categorias as $categoria)
                    <flux:table.row>
                        <flux:table.cell>{{ $categoria->id }}</flux:table.cell>
                        <flux:table.cell>{{ $categoria->nombre }}</flux:table.cell>
                        <flux:table.cell>{{ $categoria->stocks()->count() }}</flux:table.cell>
                        <flux:table.cell>
                            {{-- Boton Editar --}}
                            <flux:modal.trigger name="editar-categoria">
                                <flux:button icon="pencil" color="blue" size="sm" href="#">Editar</flux:button>
                            </flux:modal.trigger>
                            {{-- Boton Eliminar --}}
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST">
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

    <flux:modal.trigger name="crear-categoria">
        <flux:button variant="primary">Crear Categoria</flux:button>
    </flux:modal.trigger>
@endsection





{{-- Modal para CREAR una categoria --}}
<flux:modal name="crear-categoria" class="md:w-96">
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear Categoria</flux:heading>
            </div>

            <flux:input label="Nombre de la Categoria" placeholder="ej: Bebidas" name="nombre"
                value="{{ old('descripcion') }}" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </div>
    </form>
</flux:modal>


{{-- Modal para EDITAR una categoria --}}
<flux:modal name="editar-categoria" class="md:w-96">
    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar Categoria</flux:heading>
            </div>

            <flux:input label="Nombre de la Categoria" placeholder="ej: Bebidas" name="nombre"
                value="{{ $categoria->nombre }}" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </div>
    </form>
</flux:modal>
