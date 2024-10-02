@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        @media (max-width: 900px) {
            .hide-on-small {
                display: none;
            }
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control-lg {
            font-size: 1.125rem;
            padding: .75rem 1.25rem;
        }

        .form-control-alt {
            border-color: #ced4da;
        }

        .form-control-short {
            width: 150px;
        }

        .form-control-medium {
            width: 300px;
        }

        .form-control-long {
            width: 100%;
        }

        .content-container {
            margin: 1%;
            max-width: 100%;
            padding: 0 15px;
        }
    </style>
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])

    <script>
        $(document).ready(function() {
            // Add custom validation method for the name pattern
            $.validator.addMethod("pattern", function(value, element) {
                return this.optional(element) || /^[A-Za-zÀ-ÿ0-9\s]+$/.test(value);
            }, "El nombre no debe contener caracteres especiales.");

            // jQuery validation rules
            $('#registrar-empresa').validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 4,
                        maxlength: 50,
                        pattern: true // Use custom pattern validation
                    }
                },
                messages: {
                    nombre: {
                        required: "El nombre es obligatorio.",
                        minlength: "El nombre debe tener al menos 4 caracteres.",
                        maxlength: "El nombre no puede tener más de 50 caracteres."
                    }
                },
                errorClass: "text-danger", // Class to apply to error messages
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // Insert error message after the input element
                },
                submitHandler: function(form) {
                    // Format the name before submitting
                    const nombreInput = $('#nombre');
                    let formattedNombre = nombreInput.val().toLowerCase();

                    // Capitalize the first letter of each word
                    formattedNombre = formattedNombre.split(' ').map(function(word) {
                        return word.charAt(0).toUpperCase() + word.slice(1);
                    }).join(' ');

                    nombreInput.val(formattedNombre);

                    form.submit(); // This will only be called if the validation passes
                }

            });
        });
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Registrar Empresa
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Nuevo registro
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Empresas</li>
                        <li class="breadcrumb-item" aria-current="page">Registro de Empresa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>
    <div style="margin-top: 0.5rem;" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Registrar Empresa') }}</h3>
                    </div>
                    <br>
                    <div class="container">
                        <form id="registrar-empresa" action="{{ route('empresas.store') }}" method="POST">
                            @csrf
                            <div class="row">
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
                            </div>
                            <br>
                            <div class="col-12 col-lg-3 ms-auto text-lg-end">
                                <button type="submit" class="btn btn-alt-primary w-100 w-lg-auto"
                                    style="margin-bottom: 1rem;">Registrar</button>
                            </div>
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
