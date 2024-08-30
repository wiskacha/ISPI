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
                                <span id="nombre-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="papellido" class="form-label">Primer Apellido</label>
                                <input type="text" id="papellido" name="papellido"
                                    value="{{ old('papellido', $persona->papellido) }}" class="form-control" required>
                                <span id="papellido-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sapellido" class="form-label">Segundo Apellido</label>
                                <input type="text" id="sapellido" name="sapellido"
                                    value="{{ old('sapellido', $persona->sapellido) }}" class="form-control">
                                <span id="sapellido-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="carnet" class="form-label">Carnet</label>
                                <input type="number" id="carnet" name="carnet"
                                    value="{{ old('carnet', $persona->carnet) }}" class="form-control" required>
                                <span id="carnet-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="number" id="celular" name="celular"
                                    value="{{ old('celular', $persona->celular) }}" class="form-control">
                                <span id="celular-error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 align-items-center">
                            <!-- Botón de deshacer -->
                            <button type="reset" id="reset-btn" class="btn btn-warning me-2">Deshacer</button>

                            <div class="d-flex align-items-center">
                                <!-- Texto "No se han realizado cambios" -->
                                <span id="no-changes-text" class="text-muted font-italic me-3"
                                    style="display: none; white-space: nowrap;">
                                    No se han realizado cambios
                                </span>

                                <!-- Botón de actualizar -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" id="update-btn">Actualizar</button>
                                    <a href="{{ route('personas.clientes.vistaClientes') }}" class="btn btn-secondary"
                                        id="cancelar-btn">Cancelar</a>
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
    document.addEventListener("DOMContentLoaded", function() {
        const fields = {
            nombre: document.getElementById("nombre"),
            papellido: document.getElementById("papellido"),
            sapellido: document.getElementById("sapellido"),
            carnet: document.getElementById("carnet"),
            celular: document.getElementById("celular")
        };
        const updateBtn = document.getElementById("update-btn");
        const noChangesText = document.getElementById("no-changes-text");
        const originals = {
            nombre: "{{ $persona->nombre }}",
            papellido: "{{ $persona->papellido }}",
            sapellido: "{{ $persona->sapellido }}",
            carnet: "{{ $persona->carnet }}",
            celular: "{{ $persona->celular }}"
        };
        let touchedFields = new Set();

        function setInputValidity(input, isValid, formatMsg = '', existsMsg = '') {
            const errorSpan = document.getElementById(`${input.id}-error`);
            if (!isValid) {
                const message = existsMsg || formatMsg;
                input.classList.add("is-invalid");
                input.classList.remove("is-valid");
                errorSpan.textContent = message;
            } else {
                input.classList.add("is-valid");
                input.classList.remove("is-invalid");
                errorSpan.textContent = '';
            }
        }

        function resetFieldState(input) {
            input.classList.remove("is-valid", "is-invalid");
            document.getElementById(`${input.id}-error`).textContent = '';
        }

        function validateTextInput(input) {
            const regex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:\s+[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/;
            const isValid = regex.test(input.value.trim());
            setInputValidity(input, isValid, "Este campo solo puede contener letras y espacios.");
        }

        function validateCarnetInput(input) {
            const value = input.value.trim();
            const isValidFormat = value.length >= 4 && value.length <= 11;
            if (!isValidFormat) {
                setInputValidity(input, false, "El carnet debe tener entre 4 y 11 caracteres.");
                return;
            }
            if (value === originals.carnet) {
                resetFieldState(input);
                touchedFields.delete(input.id);
                return;
            }
            fetch(`/validate-carnet?value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    setInputValidity(input, !data.exists, '', "Este carnet ya está registrado.");
                    validateAllFields();
                });
        }

        function validateCelularInput(input) {
            const value = input.value.replace(/\D/g, '');
            const isValidFormat = value.length === 8;
            if (!isValidFormat) {
                setInputValidity(input, false, "El número de celular debe tener 8 dígitos.");
                return;
            }
            if (value === originals.celular) {
                resetFieldState(input);
                touchedFields.delete(input.id);
                return;
            }
            fetch(`/validate-celular?value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    setInputValidity(input, !data.exists, '', "Este número de celular ya está registrado.");
                    validateAllFields();
                });
        }

        function handleInput(input, validator) {
            touchedFields.add(input.id);
            validator(input);
            validateAllFields();
        }

        function resetTouchedFields() {
            Object.keys(fields).forEach(key => {
                const field = fields[key];
                if (field.value.trim() === originals[key].trim()) {
                    resetFieldState(field);
                    touchedFields.delete(key);
                }
            });
        }

        function validateAllFields() {
            let allValid = true;
            Object.keys(fields).forEach(key => {
                const field = fields[key];
                if (touchedFields.has(key)) {
                    switch (key) {
                        case 'nombre':
                        case 'papellido':
                        case 'sapellido':
                            validateTextInput(field);
                            break;
                        case 'carnet':
                            validateCarnetInput(field);
                            break;
                        case 'celular':
                            validateCelularInput(field);
                            break;
                    }
                    if (field.classList.contains("is-invalid")) {
                        allValid = false;
                    }
                }
            });
            noChangesText.style.display = checkAllFieldsUntouched() ? 'inline' : 'none';
            toggleUpdateButton(allValid);
        }

        function toggleUpdateButton(allValid) {
            const hasChanges = Object.keys(fields).some(key => fields[key].value.trim() !== originals[key].trim());
            updateBtn.disabled = !hasChanges || !allValid;
        }

        function checkAllFieldsUntouched() {
            return Object.keys(fields).every(key => fields[key].value.trim() === originals[key].trim());
        }

        Object.keys(fields).forEach(key => {
            fields[key].addEventListener("input", function() {
                handleInput(this, key === 'carnet' ? validateCarnetInput : key === 'celular' ? validateCelularInput : validateTextInput);
            });
        });

        document.getElementById("update-form").addEventListener("reset", function() {
            // Primero restaurar los valores originales
            Object.keys(fields).forEach(key => {
                const field = fields[key];
                field.value = originals[key];
            });

            // Después restablecer el estado de los campos
            resetTouchedFields();
            // Asegurar que todos los campos se configuren como untouched
            Object.keys(fields).forEach(key => {
                resetFieldState(fields[key]);
            });

            noChangesText.style.display = checkAllFieldsUntouched() ? 'inline' : 'none';
            toggleUpdateButton(true); // Habilitar el botón de actualización si todos los campos están intactos
        });

        validateAllFields();
    });
</script>



@endsection
