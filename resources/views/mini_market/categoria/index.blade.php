@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Categorías</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado con botón de creación --}}
        <div class="flex items-center justify-between mt-6 mb-4">
            <flux:heading size="xl">Listado de Categorías</flux:heading>
            <flux:modal.trigger name="crear-categoria">
                <flux:button variant="primary">Crear Categoría</flux:button>
            </flux:modal.trigger>
        </div>

    
        {{-- Tabla de categorías --}}
    
        <div>
            <flux:card class="space-y-6">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>ID</flux:table.column>
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

                            <flux:table.cell class="flex space-x-2">
                                {{-- Botón Editar --}}
                                <flux:modal.trigger :name="'editar-categoria-' . $categoria->id">
                                    <flux:button icon="pencil" size="sm" href="#">Editar</flux:button>
                                </flux:modal.trigger>

                                {{-- Botón Eliminar --}}
                                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST"
                                    class="inline"  onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button icon="trash" type="submit" color="destructive" size="sm">
                                        Eliminar
                                    </flux:button>
                                </form>
                            </flux:table.cell>
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
    </div>
@endsection

{{-- Modal para CREAR una categoría --}}
<flux:modal name="crear-categoria" class="md:w-96">
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <flux:heading size="lg">Crear Categoría</flux:heading>

            <flux:input label="Nombre de la Categoría" placeholder="Ej: Bebidas" name="nombre"
                value="{{ old('nombre') }}" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </div>
    </form>
</flux:modal>

{{-- Modales para EDITAR categorías --}}
@foreach ($categorias as $categoria)
    <flux:modal :name="'editar-categoria-' . $categoria->id" class="md:w-96">
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <flux:heading size="lg">Editar {{ $categoria->nombre }}</flux:heading>

                <flux:input label="Nombre de la Categoría" placeholder="Ej: Bebidas" name="nombre"
                    value="{{ $categoria->nombre }}" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Guardar</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
@endforeach
