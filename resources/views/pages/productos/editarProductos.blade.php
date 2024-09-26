@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" value="{{ $producto->codigo }}" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" step="0.01" class="form-control" value="{{ $producto->precio }}" required>
            </div>
            <div class="form-group">
                <label for="presentacion">Presentación</label>
                <input type="text" name="presentacion" id="presentacion" class="form-control" value="{{ $producto->presentacion }}">
            </div>
            <div class="form-group">
                <label for="unidad">Unidad</label>
                <input type="text" name="unidad" id="unidad" class="form-control" value="{{ $producto->unidad }}" required>
            </div>
            <div class="form-group">
                <label for="id_empresa">ID Empresa</label>
                <input type="number" name="id_empresa" id="id_empresa" class="form-control" value="{{ $producto->id_empresa }}">
            </div>
            <div class="form-group">
                <label for="tags">Tags (separados por comas)</label>
                <input type="text" name="tags" id="tags" class="form-control" value="{{ implode(',', $producto->tags ?? []) }}">
            </div>

            <div class="form-group">
                <label for="adjuntos">Adjuntos</label>
                <input type="file" name="adjuntos[]" id="adjuntos" class="form-control" multiple>
                <small class="form-text text-muted">Puedes subir múltiples archivos.</small>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>

        <h2>Adjuntos Existentes</h2>
        <ul>
            @foreach ($producto->adjuntos as $adjunto)
                <li>{{ $adjunto->descripcion }} - <a href="{{ asset($adjunto->uri) }}" target="_blank">Ver</a></li>
            @endforeach
        </ul>
    </div>
@endsection
