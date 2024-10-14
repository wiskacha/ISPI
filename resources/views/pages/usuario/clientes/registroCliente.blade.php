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

    <script>
        function showConfirmationModal() {
            // Get the form data
            document.getElementById('confirmNombre').innerText = document.getElementById('nombre').value;
            document.getElementById('confirmPapellido').innerText = document.getElementById('papellido').value;
            document.getElementById('confirmCarnet').innerText = document.getElementById('carnet').value;
            document.getElementById('confirmSapellido').innerText = document.getElementById('sapellido').value || 'N/A';
            document.getElementById('confirmCelular').innerText = document.getElementById('celular').value || 'N/A';

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }

        function submitForm() {
            // Submit the form
            document.getElementById('registerForm').submit();
        }
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Registrar Cliente
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Nuevo registro
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Clientes
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Registro de Cliente
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>
    <div class="content-container">
        <form action="{{ route('usuario.registerCl') }}" method="POST" class="js-validation-signup" id="registerForm">
            @csrf

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Registro de Cliente</h3>
                </div>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Required Inputs -->
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="nombre"
                                    name="nombre" placeholder="Nombres" required>
                                <label for="nombre">Nombres</label>
                            </div>

                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="papellido"
                                    name="papellido" placeholder="Primer Apellido" required>
                                <label for="papellido">Primer Apellido</label>
                            </div>

                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="carnet"
                                    name="carnet" placeholder="Cédula de Identidad" required>
                                <label for="carnet">Cédula de Identidad</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Optional Inputs -->
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-medium" id="sapellido"
                                    name="sapellido" placeholder="Segundo Apellido">
                                <label for="sapellido">Segundo Apellido (Opcional)</label>
                            </div>

                            <div class="form-floating">
                                <input type="text"
                                    class="form-control form-control-lg form-control-alt form-control-short" id="celular"
                                    name="celular" placeholder="Celular">
                                <label for="celular">Celular (Opcional)</label>
                            </div>
                        </div>

                        <!-- Button Centering -->
                        <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                            <a href="{{ route('personas.clientes.vistaClientes') }}" class="btn btn-secondary me-2"
                                style="margin-bottom: 1rem;">Cancelar</a>
                            <!-- Trigger the modal on button click -->
                            <button type="button" class="btn btn-alt-primary" style="margin-bottom: 1rem;"
                                onclick="showConfirmationModal()">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Por favor confirme que la siguiente información es correcta antes de enviar:</p>
                    <ul>
                        <li><strong>Nombres:</strong> <span id="confirmNombre"></span></li>
                        <li><strong>Primer Apellido:</strong> <span id="confirmPapellido"></span></li>
                        <li><strong>Cédula de Identidad:</strong> <span id="confirmCarnet"></span></li>
                        <li><strong>Segundo Apellido:</strong> <span id="confirmSapellido"></span></li>
                        <li><strong>Celular:</strong> <span id="confirmCelular"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Submit the form when confirmed -->
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Confirmar</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var nombreInput = document.getElementById("nombre");
            var papellidoInput = document.getElementById("papellido");
            var sapellidoInput = document.getElementById("sapellido");
            var carnetInput = document.getElementById("carnet");
            var celularInput = document.getElementById("celular");

            function validateInput(inputElement) {
                var inputValue = inputElement.value.trim();
                var regex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:\s+[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/;
                if (!regex.test(inputValue)) {
                    inputElement.value = "";
                }
            }

            nombreInput.addEventListener("input", function() {
                validateInput(this);
            });

            papellidoInput.addEventListener("input", function() {
                validateInput(this);
            });

            sapellidoInput.addEventListener("input", function() {
                validateInput(this);
            });

            carnetInput.addEventListener("input", function() {
                if (this.value.length > 100) {
                    this.value = this.value.slice(0, 100); // Limit to 100 characters
                }
            });

            celularInput.addEventListener("input", function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');

                // Limit to 11 digits
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }
            });

        });
    </script>

@endsection
