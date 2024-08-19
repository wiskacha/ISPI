@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        @media (max-width: 705px) {
            .hide-on-small {
                display: none;
            }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElementList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElementList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                })
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
@endsection

@section('content')
    <!-- Modal Structure -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas actualizar la información con los siguientes datos?</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nuevo Perfil</h5>
                                    <p class="card-text"><strong>Nombre:</strong> <span id="modal-nombre"></span></p>
                                    <p class="card-text"><strong>Primer Apellido:</strong> <span
                                            id="modal-papellido"></span></p>
                                    <p class="card-text"><strong>Segundo Apellido:</strong> <span
                                            id="modal-sapellido"></span></p>
                                    <p class="card-text"><strong>Carnet:</strong> <span id="modal-carnet"></span></p>
                                    <p class="card-text"><strong>Celular:</strong> <span id="modal-celular"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-muted">
                                    <h5 class="card-title">Viejo Perfil</h5>
                                    <p class="card-text"><strong>Nombre:</strong> <span id="old-nombre"></span></p>
                                    <p class="card-text"><strong>Primer Apellido:</strong> <span id="old-papellido"></span>
                                    </p>
                                    <p class="card-text"><strong>Segundo Apellido:</strong> <span id="old-sapellido"></span>
                                    </p>
                                    <p class="card-text"><strong>Carnet:</strong> <span id="old-carnet"></span></p>
                                    <p class="card-text"><strong>Celular:</strong> <span id="old-celular"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-update">Confirmar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Editar Persona
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Personas
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editar Persona
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded m-2">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Editar Persona
            </h3>
        </div>
        <div class="container mt-4">
            <div class="">
                <div class="card-body">
                    <form id="update-form" action="{{ route('personas.updateCliente', $persona) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre"
                                    value="{{ old('nombre', $persona->nombre) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="papellido" class="form-label">Primer Apellido</label>
                                <input type="text" id="papellido" name="papellido"
                                    value="{{ old('papellido', $persona->papellido) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sapellido" class="form-label">Segundo Apellido</label>
                                <input type="text" id="sapellido" name="sapellido"
                                    value="{{ old('sapellido', $persona->sapellido) }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="carnet" class="form-label">Carnet</label>
                                <input type="number" id="carnet" name="carnet"
                                    value="{{ old('carnet', $persona->carnet) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" id="celular" name="celular"
                                    value="{{ old('celular', $persona->celular) }}" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <!-- Reset button on the left -->
                            <button type="reset" class="btn btn-warning me-2">Deshacer</button>

                            <!-- Button group on the right -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary" id="update-btn">Actualizar</button>
                                <a href="{{ route('personas.clientes.vistaClientes') }}" class="btn btn-secondary"
                                    id="cancelar-btn">Cancelar</a>

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

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateBtn = document.getElementById('update-btn');
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

            updateBtn.addEventListener('click', function() {
                // Set values for new details
                document.getElementById('modal-nombre').textContent = document.getElementById('nombre')
                    .value;
                document.getElementById('modal-papellido').textContent = document.getElementById(
                    'papellido').value;
                document.getElementById('modal-sapellido').textContent = document.getElementById(
                    'sapellido').value;
                document.getElementById('modal-carnet').textContent = document.getElementById('carnet')
                    .value;
                document.getElementById('modal-celular').textContent = document.getElementById('celular')
                    .value;

                // Set values for old details
                document.getElementById('old-nombre').textContent =
                    "{{ old('nombre', $persona->nombre) }}";
                document.getElementById('old-papellido').textContent =
                    "{{ old('papellido', $persona->papellido) }}";
                document.getElementById('old-sapellido').textContent =
                    "{{ old('sapellido', $persona->sapellido) }}";
                document.getElementById('old-carnet').textContent =
                    "{{ old('carnet', $persona->carnet) }}";
                document.getElementById('old-celular').textContent =
                    "{{ old('celular', $persona->celular) }}";

                // Show modal
                confirmModal.show();
            });

            document.getElementById('confirm-update').addEventListener('click', function() {
                document.getElementById('update-form').submit();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelarButton = document.getElementById('cancelar-btn');

            if (cancelarButton) {
                cancelarButton.addEventListener('click', function(event) {
                    // Prevent the default link action
                    event.preventDefault();

                    // Show confirmation dialog
                    const confirmed = confirm(
                        '¿Estás seguro de que quieres cancelar? Todos los cambios no guardados se perderán.'
                    );

                    if (confirmed) {
                        // Redirect to the route if confirmed
                        window.location.href = cancelarButton.href;
                    }
                });
            }
        });
    </script>

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
                if (this.value.length > 13) {
                    this.value = this.value.slice(0, 13); // Limit to 100 characters
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
