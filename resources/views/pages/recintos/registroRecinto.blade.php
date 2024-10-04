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
            /* Adjust this value as needed */
            padding: 0 15px;
            /* Add some padding on the sides */
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

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Registrar Recinto
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Nuevo registro
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Recintos
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Registro de Recinto
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>
    <div class="content-container">
        <form action="/recintos/register" method="POST" class="js-validation-signup">
            @csrf

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Registro de Recinto</h3>
                </div>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Required Inputs -->
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="nombre"
                                    name="nombre" placeholder="Nombre del Recinto" required>
                                <label for="nombre">Nombre del Recinto</label>
                            </div>

                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="direccion"
                                    name="direccion" placeholder="Dirección" required>
                                <label for="direccion">Dirección</label>
                            </div>

                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="telefono"
                                    name="telefono" placeholder="Teléfono" required>
                                <label for="telefono">Teléfono</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Optional Inputs -->
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-short" id="tipo"
                                    name="tipo" placeholder="Tipo">
                                <label for="tipo">Tipo (Opcional)</label>
                            </div>
                        </div>

                        <!-- Button Centering -->
                        <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                            <a href="{{ route('recintos.vista') }}" class="btn btn-secondary me-2"
                                style="margin-bottom: 1rem;">Cancelar</a>
                            <button type="submit" class="btn btn-alt-primary"
                                style="margin-bottom: 1rem;">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var nombreInput = document.getElementById("nombre");
            var direccionInput = document.getElementById("direccion");
            var telefonoInput = document.getElementById("telefono");
            var tipoInput = document.getElementById("tipo");

            function validateInput(inputElement) {
                var inputValue = inputElement.value.trim();
                var regex = /^[a-zA-Z0-9\sñÑáéíóúÁÉÍÓÚ,.-#]+$/; // Permitir alfanuméricos, espacios, y símbolos utilizados en direcciones
                if (!regex.test(inputValue)) {
                    inputElement.value = "";
                }
            }

            nombreInput.addEventListener("input", function() {
                validateInput(this);
            });

            direccionInput.addEventListener("input", function() {
                validateInput(this);
            });
            telefonoInput.addEventListener("input", function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');

                // Limit to 8 digits
                if (this.value.length > 9) {
                    this.value = this.value.slice(0, 9);
                }
            });

            tipoInput.addEventListener("input", function() {
                validateInput(this);
            });

        });
    </script>

@endsection
