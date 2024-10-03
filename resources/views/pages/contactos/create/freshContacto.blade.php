@extends('layouts.backend')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        @media (max-width: 900px) {
            .hide-on-small {
                display: none;
            }
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Registro de Contacto</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Nuevo contacto para la empresa</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Contactos</li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo Contacto</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Registrar Nuevo Contacto') }}</h3>
                    </div>
                    <br>
                    <div class="container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" id="newContactoForm" action="{{ route('contactos.register') }}">
                            @csrf
                            <div class="row">
                                <!-- Nombre Field -->
                                <div class="col-md-6 order-1 order-md-1">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="nombre" name="nombre" placeholder="Nombre" required>
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Apellido Field -->
                                <div class="col-md-6 order-2 order-md-2">
                                    <div class="form-group">
                                        <label for="papellido">Primer Apellido</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="papellido" name="papellido" placeholder="Apellido" required>
                                        @error('papellido')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Segundo Apellido Field -->
                                <div class="col-md-6 order-3 order-md-4">
                                    <div class="form-group">
                                        <label for="sapellido">Segundo Apellido(Opcional)</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="sapellido" name="sapellido" placeholder="Segundo Apellido">
                                        @error('sapellido')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Carnet Field -->
                                <div class="col-md-6 order-5 order-md-5">
                                    <div class="form-group">
                                        <label for="carnet">Carnet</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="carnet" name="carnet" placeholder="Carnet" required>
                                        @error('carnet')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- celular Field -->
                                <div class="col-md-6 order-4 order-md-3">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="celular" name="celular" placeholder="Teléfono" required>
                                        @error('celular')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Empresa Field -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_empresa">Empresa</label>
                                        <div class="col-md-5 col-12">
                                            <select class="js-example-basic-single form-control form-control-lg"
                                                id="id_empresa" name="id_empresa" required>
                                                <option value="" disabled selected>Selecciona una empresa</option>
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_empresa')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-0">
                                <div class="col-md-3 offset-md-9 col-12 text-center text-md-right">
                                    <button type="submit" class="btn btn-primary w-100 w-md-25" disabled>Registrar</button>
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
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            // Add custom regex method
            $.validator.addMethod("regex", function(value, element, regexpr) {
                return this.optional(element) || regexpr.test(value);
            });
            // Select2 for the empresa select field
            $('#id_empresa').select2({
                placeholder: "Selecciona una empresa",
                allowClear: true,
            });

            // jQuery Validation for the form
            $("#newContactoForm").validate({
                ignore: [],
                rules: {
                    nombre: {
                        required: true,
                        maxlength: 100,
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                    },
                    papellido: {
                        required: true,
                        maxlength: 100,
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                    },
                    sapellido: {
                        maxlength: 100,
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                    },
                    carnet: {
                        required: true,
                        maxlength: 14,
                        digits: true,
                        minlength: 4
                    },
                    celular: {
                        required: true,
                        maxlength: 8,
                        digits: true,
                        minlength: 8
                    },
                    id_empresa: {
                        required: true
                    }
                },
                messages: {
                    nombre: {
                        required: "El nombre es requerido.",
                        maxlength: "El nombre no puede tener más de 100 caracteres.",
                        regex: "El nombre solo debe contener letras.",
                    },
                    papellido: {
                        required: "El apellido es requerido.",
                        maxlength: "El apellido no puede tener más de 100 caracteres.",
                        regex: "El apellido solo debe contener letras.",
                    },
                    sapellido: {
                        regex: "El apellido solo debe contener letras.",
                        maxlength: "El apellido no puede tener más de 100 caracteres.",
                    },
                    carnet: {
                        required: "El carnet es requerido.",
                        maxlength: "El carnet no puede tener más de 14 caracteres.",
                        digits: "El carnet debe ser un número.",
                        minlength: "El carnet debe tener al menos 4 caracteres.",
                    },
                    celular: {
                        required: "El teléfono es requerido.",
                        maxlength: "El teléfono no puede tener más de 8 caracteres.",
                        digits: "El teléfono debe ser un número.",
                        minlength: "El teléfono debe tener al menos 8 caracteres."
                    },
                    id_empresa: {
                        required: "Debe seleccionar una empresa."
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    if (element.hasClass("js-example-basic-single")) {
                        error.insertAfter(element.next('span')); // For Select2 elements
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    form.submit(); // Submit the form when valid
                }
            });

            // Function to check the entire form's validity and toggle the submit button
            function toggleSubmitButton() {
                if ($("#newContactoForm").valid()) {
                    $('button[type="submit"]').removeAttr('disabled');
                } else {
                    $('button[type="submit"]').attr('disabled', 'disabled');
                }
            }

            // Run the validation check on any input/select change
            $('#newContactoForm input, #newContactoForm select').on('input change', toggleSubmitButton);

            // Trigger the initial state for the submit button
            toggleSubmitButton();
        });
    </script>
@endsection
