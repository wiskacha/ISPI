@extends('layouts.backend')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        @media (max-width: 900px) {
            .hide-on-small {
                display: none;
            }
        }

        /* label bottom-margin 0.5rem */
        label {
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;
        }

        .content-container {
            margin: 1%;
            max-width: 100%;
            padding: 0 15px;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control-lg {
            font-size: 1.125rem;
            padding: .75rem 1.25rem;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Registrar Producto
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Nuevo registro
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Productos
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Registro de Producto
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div style="margin-top: 0.5rem;" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Registrar Producto') }}</h3>
                    </div>
                    <br>
                    <div class="container">
                        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Código Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="codigo">Código</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            name="codigo" id="codigo" placeholder="Código" required>
                                        @error('codigo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nombre Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            name="nombre" id="nombre" placeholder="Nombre" required>
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Precio Field -->
                                <div class="col-6 col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="precio">Precio</label>
                                        <input type="number" step="0.01"
                                            class="form-control form-control-lg form-control-alt" name="precio"
                                            id="precio" placeholder="Precio" required>
                                        @error('precio')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Unidad Field -->
                                <div class="col-6 col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="unidad">Unidad</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            name="unidad" id="unidad" placeholder="Unidad" required>
                                        @error('unidad')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Presentación Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="presentacion">Presentación</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            name="presentacion" id="presentacion" placeholder="Presentación" required>
                                        @error('presentacion')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <!-- ID Empresa Field -->
                                <!-- ID Empresa Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label class="col-12 col-md-12" for="id_empresa">ID Empresa</label>
                                        <select class="col-auto col-md-12 js-example-basic-single form-control-lg"
                                            id="id_empresa" name="id_empresa" required>
                                            <option value="" disabled selected>Selecciona una empresa</option>
                                            @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id_empresa }}">
                                                    [{{ $empresa->nombre }}]
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_empresa')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Tags Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="tags">Tags (separados por comas)</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            name="tags" id="tags" placeholder="Tags">
                                        @error('tags')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Adjuntos Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="adjuntos">Imagen</label>
                                        <input type="file" class="form-control form-control-lg form-control-alt"
                                            name="adjuntos[]" id="adjuntos" accept=".png, .jpg, .jpeg">
                                        <small class="form-text text-muted">Debe ser un archivo de imágen.</small>
                                        @error('adjuntos')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-3 offset-md-9 col-12 text-center text-md-right order-1">
                                    <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                                </div>

                            </div>
                            <br>
                        </form>
                    </div>
                </div>
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

            // Input masking for specific fields
            $('#codigo').mask('0000000000'); // Numeric only, minimum 6 digits
            $('#precio').mask('000000000000.00', {
                translation: {
                    '0': {
                        pattern: /[0-9]/,
                        optional: true
                    }
                }
            });
            $('#unidad').mask('00000'); // Integer only

            // jQuery validation rules
            $('#registrar-producto').validate({
                rules: {
                    codigo: {
                        required: true,
                        minlength: 6,
                        digits: true
                    },
                    nombre: {
                        required: true,
                        minlength: 4,
                        maxlength: 30,
                        pattern: /^[A-Za-zÀ-ÿ\s]+$/ // Only letters and spaces, including accents/tildes
                    },
                    precio: {
                        required: true,
                        number: true,
                        min: 0,
                    },
                    unidad: {
                        required: true,
                        digits: true
                    },
                    presentacion: {
                        required: true,
                        maxlength: 30,
                        pattern: /^[A-Za-zÀ-ÿ0-9\s]+$/ // Letters, numbers, and spaces
                    }
                },
                messages: {
                    codigo: {
                        required: "El código es obligatorio.",
                        minlength: "El código debe tener al menos 6 dígitos.",
                        digits: "El código solo debe contener números."
                    },
                    nombre: {
                        required: "El nombre es obligatorio.",
                        minlength: "El nombre debe tener al menos 4 caracteres.",
                        maxlength: "El nombre no puede tener más de 30 caracteres.",
                        pattern: "El nombre no debe contener números o caracteres especiales."
                    },
                    precio: {
                        required: "El precio es obligatorio.",
                        number: "Por favor, ingresa un valor numérico válido."
                    },
                    unidad: {
                        required: "La unidad es obligatoria.",
                        digits: "La unidad solo debe contener números enteros."
                    },
                    presentacion: {
                        required: "La presentación es obligatoria.",
                        maxlength: "La presentación no puede tener más de 30 caracteres.",
                        pattern: "La presentación debe contener solo letras, números o espacios."
                    }
                }
            });
        });
    </script>
@endsection
