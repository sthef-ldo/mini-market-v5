@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('stock.index') }}">Stock</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#">Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mt-6 mb-8">
            <flux:heading size="xl">Editar Stock</flux:heading>
        </div>

        {{-- Card principal --}}
        <flux:card>
            <form action="{{ route('stock.update', $stock->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <flux:heading size="lg">Editar stock "{{ $stock->nombre }}"</flux:heading>

                    {{-- Campos del formulario --}}
                    <flux:input label="Nombre del Producto" type="text" placeholder="Ej: Arroz" name="nombre"
                        value="{{ old('nombre', $stock->nombre) }}" required />

                    <flux:input label="Cantidad" type="number" placeholder="Ej: 21" name="cantidad"
                        value="{{ old('cantidad', $stock->cantidad) }}" required />

                    <flux:input label="Precio" type="number" step="0.01" placeholder="Ej: 29.99" name="precio"
                        value="{{ old('precio', $stock->precio) }}" required />

                    {{-- Selector de categorías --}}
                    <flux:select label="Categoría" name="categoria_id">
                        @foreach ($categorias as $categoria)
                            <flux:select.option value="{{ $categoria->id }}"
                                :selected="old('categoria_id', $stock->categoria_id) == $categoria->id">
                                {{ $categoria->nombre }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- Descripción del elemento --}}
                    <flux:textarea name="descripcion" rows="4" label="Descripción"
                        placeholder="Descripción del producto (opcional)">{{ old('descripcion', $stock->descripcion) }}
                    </flux:textarea>

                    <flux:input label="Imagen" type="file"  name="imagen" value="{{ old('imagen') }}"  />


                    {{-- Botones de acción alineados a la derecha --}}
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('stock.index') }}">
                            <flux:button variant="outline">Cancelar</flux:button>
                        </a>
                        <flux:button type="submit" variant="primary">
                            Guardar Cambios
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:card>
    </div>
@endsection
