@extends('layouts.backend')

@section('css')
    <!-- Add necessary CSS here -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="content content-boxed">
        <!-- Product Edit -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Editar Producto</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Actualiza los detalles del producto.
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <!-- Nombre -->
                            <div class="mb-4">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="{{ old('nombre', $producto->nombre) }}">
                            </div>

                            <!-- Código -->
                            <div class="mb-4">
                                <label class="form-label" for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"
                                    value="{{ old('codigo', $producto->codigo) }}">
                            </div>

                            <!-- Precio -->
                            <div class="mb-4">
                                <label class="form-label" for="precio">Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio"
                                    value="{{ old('precio', $producto->precio) }}">
                            </div>

                            {{-- Unidad --}}
                            <div class="mb-4">
                                <label class="form-label" for="unidad">Unidad</label>
                                <input type="text" class="form-control" id="unidad" name="unidad"
                                    value="{{ old('unidad', $producto->unidad) }}">
                            </div>

                            <!-- Presentación -->
                            <div class="mb-4">
                                <label class="form-label" for="presentacion">Presentación</label>
                                <input type="text" class="form-control" id="presentacion" name="presentacion"
                                    value="{{ old('presentacion', $producto->presentacion) }}">
                            </div>

                            <!-- Empresa -->
                            <div class="mb-4">
                                <label class="form-label" for="empresa">Empresa</label>
                                <select class="form-control" id="empresa" name="empresa_id">
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}"
                                            {{ $producto->empresa_id == $empresa->id ? 'selected' : '' }}>
                                            {{ $empresa->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tags -->
                            <div class="mb-4">
                                <label class="form-label" for="tags">Tags</label>
                                <textarea class="form-control" id="tags" name="tags">{{ old('tags', implode("\n", json_decode($producto->tags, true) ?? [])) }}</textarea>
                                <small class="text-muted">Escribe cada tag en una nueva línea.</small>
                            </div>

                            <!-- Imagen actual -->
                            <div class="mb-4">
                                <label class="form-label">Imagen actual</label>
                                <div class="mb-4">
                                    @if (Storage::exists(
                                            'public/productos/' .
                                                substr($producto->nombre, 0, 4) .
                                                '_' .
                                                $producto->created_at->format('YmdHis') .
                                                '/main/main.png'))
                                        <img src="{{ asset('storage/productos/' . substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis') . '/main/main.png') }}"
                                            style="max-width: 100px;" alt="Producto Imagen">
                                    @else
                                        <img src="https://via.placeholder.com/100" alt="No Image">
                                    @endif
                                </div>
                                <label for="image" class="form-label">Subir nueva imagen</label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>

                            <!-- Checkbox to delete the current image -->
                            <div class="mb-4">
                                <label for="delete_image" class="form-label">Eliminar imagen actual</label>
                                <input type="checkbox" id="delete_image" name="delete_image">
                                <small class="text-muted">Marque esta opción para eliminar la imagen actual.</small>
                            </div>

                            <!-- Update Button -->
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <!-- Add necessary JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> <!-- Input mask plugin -->
    <script>
        $(document).ready(function() {
            // Apply Select2 to the ID Empresa field
            $('#id_empresa').select2({
                placeholder: "Selecciona una empresa",
                allowClear: true,
            });
        });
    </script>
@endsection
