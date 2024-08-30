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
    @include('partials.confirmation-modal', ['persona' => $persona])

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
                                <span id="carnet-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" id="celular" name="celular"
                                    value="{{ old('celular', $persona->celular) }}" class="form-control">
                                <span id="celular-error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <!-- Botón de deshacer -->
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
            const form = document.getElementById('update-form');
            const inputs = form.querySelectorAll('input[required], input[type="text"], input[type="number"]');

            function validateForm() {
                let isValid = true;
                inputs.forEach(input => {
                    if (input.dataset.touched === 'true') { // Solo si el usuario ha interactuado
                        if (!input.checkValidity()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                    }
                });
                updateBtn.disabled = !isValid;
            }


            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.dataset.touched = 'true';
                    validateForm();
                });
            });
        });
    </script>

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
            var updateBtn = document.getElementById("update-btn");

            var originalCarnet = "{{ $persona->carnet }}";
            var originalCelular = "{{ $persona->celular }}";

            function setInputValidity(inputElement, isValid) {
                if (isValid) {
                    inputElement.classList.remove("is-invalid");
                    inputElement.classList.add("is-valid");
                } else {
                    inputElement.classList.remove("is-valid");
                    inputElement.classList.add("is-invalid");
                }
            }

            function validateTextInput(inputElement) {
                var inputValue = inputElement.value.trim();
                var regex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:\s+[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/;
                if (!regex.test(inputValue)) {
                    setInputValidity(inputElement, false);
                    return false;
                } else {
                    setInputValidity(inputElement, true);
                    return true;
                }
            }

            function validateCarnetInput(inputElement) {
                var inputValue = inputElement.value.trim();

                // Ignorar si el valor es el mismo que el original
                if (inputValue === originalCarnet) {
                    setInputValidity(inputElement, true);
                    updateBtn.disabled = false;
                    return true;
                }

                if (inputValue.length > 11 || inputValue.length < 4) {
                    inputElement.value = inputValue.slice(0, 12);
                    setInputValidity(inputElement, false);
                    updateBtn.disabled = true;
                    return false;

                }

                fetch("/validate-carnet?value=" + encodeURIComponent(inputValue))
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            setInputValidity(inputElement, false);
                            updateBtn.disabled = true;
                        } else {
                            setInputValidity(inputElement, true);
                            updateBtn.disabled = false;
                        }
                    });

                return true;
            }

            function validateCelularInput(inputElement) {
                var inputValue = inputElement.value.replace(/\D/g, '');

                // Ignorar si el valor es el mismo que el original
                if (inputValue === originalCelular) {
                    setInputValidity(inputElement, true);
                    updateBtn.disabled = false;
                    return true;
                }

                if (inputValue.length != 8) {
                    inputElement.value = inputValue.slice(0, 8);
                    setInputValidity(inputElement, false);
                    updateBtn.disabled = true;
                    return false;
                }

                fetch("/validate-celular?value=" + encodeURIComponent(inputValue))
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            setInputValidity(inputElement, false);
                            updateBtn.disabled = true;
                        } else {
                            setInputValidity(inputElement, true);
                            updateBtn.disabled = false;
                        }
                    });

                return true;
            }

            nombreInput.addEventListener("input", function() {
                validateTextInput(this);
            });

            papellidoInput.addEventListener("input", function() {
                validateTextInput(this);
            });

            sapellidoInput.addEventListener("input", function() {
                validateTextInput(this);
            });

            carnetInput.addEventListener("input", function() {
                validateCarnetInput(this);
            });

            celularInput.addEventListener("input", function() {
                validateCelularInput(this);
            });
        });
    </script>
@endsection
