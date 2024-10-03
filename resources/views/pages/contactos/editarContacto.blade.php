@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Ensures that hide-on-small class hides elements on small screens */
        @media (max-width: 705px) {
            .hide-on-small {
                display: none !important;
            }
        }

        /* For screens up to 767px */
        @media (max-width: 764px) {
            #no-changes-text {
                display: none !important;
            }

            #no-changes-icon {
                display: inline;
            }
        }

        /* For screens 768px and up */
        @media (min-width: 765px) {
            #no-changes-text {
                display: inline;
            }

            #no-changes-icon {
                display: none !important;
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

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- editarPersona.blade.php -->

    <!-- Modal Structure -->
    @include('partials.confirmation-modal', ['persona' => $persona])

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Editar Persona</h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Personas</li>
                        <li class="breadcrumb-item" aria-current="page">Editar Persona</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded m-2">
        <div class="block-header block-header-default">
            <h3 class="block-title">Editar Persona</h3>
        </div>
        <div class="container mt-4">
            <div class="card-body">
                <form id="update-form" action="{{ route('personas.updateCliente', $persona) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- or the correct method for your update route -->

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
                        <button type="reset-btn" id="reset-btn" class="btn btn-warning me-2">Deshacer</button>

                        <div class="d-flex align-items-center">
                            <!-- Texto "No se han realizado cambios" -->
                            <span id="no-changes-text" class="text-muted font-italic me-3" style="white-space: nowrap;">No
                                se han realizado cambios</span>

                            <!-- Ícono para pantallas pequeñas -->
                            <i id="no-changes-icon" class="fas fa-lock text-muted me-3" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="No se han realizado cambios" style="display: none;"></i>

                            <!-- Botón de actualizar -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary" id="update-btn" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal">Actualizar</button>
                                <a href="{{ route('contactos.vistaContactos') }}" class="btn btn-secondary"
                                    id="cancelar-btn">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de Contactos
            </h3>
            <div class="ms-3">
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#modal-block-vcenter">
                    <i class="fa fa-plus"></i>
                    <span class="d-none d-sm-inline">Nuevo Contacto</span>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th style="width: 30%;">Empresas</th>
                            <th class="text-center" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contactos as $index => $contacto)
                            <tr>
                                <td class="text-center hide-on-small">{{ $index + 1 }}</td>
                                <td>{{ $contacto->empresa->nombre }}</td>
                                <td class="text-center">
                                    <!-- Delete Button to Open Modal -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $contacto->id_persona }}-{{ $contacto->id_empresa }}">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade"
                                id="deleteModal{{ $contacto->id_persona }}-{{ $contacto->id_empresa }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el contacto de:
                                            <br>
                                            <strong>{{ $contacto->persona->nombre }}</strong>
                                            <br>
                                            de la empresa:
                                            <br>
                                            <strong>{{ $contacto->empresa->nombre }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form
                                                action="{{ route('contactos.destroy', ['id_persona' => $contacto->id_persona, 'id_empresa' => $contacto->id_empresa]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
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
    <div class="modal fade" id="modal-block-vcenter" tabindex="-1" role="dialog"
        aria-labelledby="modal-block-vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-block-vcenter">Añadir Contacto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contactos.QregisterE') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 col-md-6" style="margin-bottom: 2rem;">
                                <div class="form-group">
                                    <label for="id_persona" style="margin-bottom: 1rem;">Persona</label>
                                    <select class="js-example-basic-single form-control form-control-lg" id="id_persona"
                                        name="id_persona" required>
                                        <option value="{{ $persona->id_persona }}">{{ $persona->papellido }}
                                            [{{ $persona->carnet }}]</option>
                                    </select>
                                    @error('id_persona')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="id_empresa" class="w-100" style="margin-bottom: 1rem;">Empresa</label>
                                    <select class="js-example-basic-single form-control form-control-lg" id="id_empresa"
                                        name="id_empresa" required style="width: 100%;">
                                        <option value="" disabled selected>Selecciona una empresa</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_empresa')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" style="margin-bottom: 1rem;"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-alt-primary"
                                style="margin-bottom: 1rem;">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                if (window.jQuery) {
                    // Initialize Select2 for the empresa and persona select fields
                    $('#id_empresa').select2({
                        default: "{{ $persona->id_persona }}",
                        placeholder: "Selecciona una empresa",
                        allowClear: false,
                        dropdownParent: $(
                            '#modal-block-vcenter'), // Ensure the dropdown is relative to the modal
                    });
                }
                @if (session('modal'))
                    var myModal = new bootstrap.Modal(document.getElementById('modal-block-vcenter'));
                    myModal.show();
                @endif
                const fields = {
                    nombre: document.getElementById("nombre"),
                    papellido: document.getElementById("papellido"),
                    sapellido: document.getElementById("sapellido"),
                    carnet: document.getElementById("carnet"),
                    celular: document.getElementById("celular")
                };
                const updateBtn = document.getElementById("update-btn");
                const resetBtn = document.getElementById("reset-btn");
                const noChangesText = document.getElementById("no-changes-text");
                const noChangesIcon = document.getElementById("no-changes-icon");

                // Original values for comparison
                const originals = {
                    nombre: "{{ $persona->nombre }}",
                    papellido: "{{ $persona->papellido }}",
                    sapellido: "{{ $persona->sapellido }}",
                    carnet: "{{ $persona->carnet }}",
                    celular: "{{ $persona->celular }}"
                };

                let touchedFields = new Set();
                let debounceTimeouts = {};

                /* ------------- Utility Functions ------------- */

                // Debounce function to prevent excessive API requests
                function debounce(func, delay) {
                    return function(...args) {
                        const key = args[0].id;
                        if (debounceTimeouts[key]) {
                            clearTimeout(debounceTimeouts[key]);
                        }
                        debounceTimeouts[key] = setTimeout(() => func(...args), delay);
                    };
                }

                // Set the validity state and error message for an input
                function setInputValidity(input, isValid, formatMsg = '', existsMsg = '') {
                    const errorSpan = document.getElementById(`${input.id}-error`);
                    if (isValid) {
                        input.classList.remove("is-invalid");
                        input.classList.add("is-valid");
                        errorSpan.textContent = '';
                    } else {
                        input.classList.remove("is-valid");
                        input.classList.add("is-invalid");
                        errorSpan.textContent = existsMsg || formatMsg;
                    }
                    validateAllFields(); // Revalidate all fields on any change
                }

                // Reset the state of an input field
                function resetFieldState(input) {
                    input.classList.remove("is-valid", "is-invalid");
                    const errorSpan = document.getElementById(`${input.id}-error`);
                    if (errorSpan) errorSpan.textContent = '';
                }

                // Check if there are any changes compared to the original values
                function hasChanges() {
                    return fields.nombre.value.trim() !== originals.nombre.trim() ||
                        fields.papellido.value.trim() !== originals.papellido.trim() ||
                        fields.sapellido.value.trim() !== originals.sapellido.trim() ||
                        fields.carnet.value.trim() !== originals.carnet.trim() ||
                        fields.celular.value.trim() !== originals.celular.trim();
                }

                // Validate all touched fields and enable or disable the update button
                function validateAllFields() {
                    const allValid = Array.from(touchedFields).every(id => {
                        const input = fields[id];
                        return input.classList.contains("is-valid");
                    });

                    const changesMade = hasChanges();

                    // Enable button only if all fields are valid and changes are made
                    if (allValid && changesMade) {
                        updateBtn.disabled = false;
                        noChangesText.style.display = 'none';
                        noChangesIcon.style.display = 'none';
                    } else {
                        updateBtn.disabled = true;
                        if (!changesMade) {
                            noChangesText.style.display = 'inline';
                            noChangesIcon.style.display = 'inline';
                        } else {
                            noChangesText.style.display = 'none';
                            noChangesIcon.style.display = 'none';
                        }
                    }
                }

                // Reset the form to its original values and clear validation states
                function resetToOriginalValues() {
                    fields.nombre.value = originals.nombre;
                    fields.papellido.value = originals.papellido;
                    fields.sapellido.value = originals.sapellido;
                    fields.carnet.value = originals.carnet;
                    fields.celular.value = originals.celular;

                    // Clear validation states and touched fields
                    Object.keys(fields).forEach(key => {
                        resetFieldState(fields[key]);
                    });
                    touchedFields.clear();

                    // Revalidate the fields after resetting
                    validateAllFields();
                }

                /* ------------- Field Validation Functions ------------- */

                // Validate text inputs for only alphabetic characters and spaces
                function validateTextInput(input) {
                    const regex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:\s+[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*$/;
                    const isValid = regex.test(input.value.trim());
                    setInputValidity(input, isValid, "Este campo solo puede contener letras y espacios.");
                }

                // Validate carnet input by checking the length and API uniqueness check
                function validateCarnetInput(input) {
                    const value = input.value.trim();
                    const isValidFormat = value.length >= 4 && value.length <= 11;

                    if (!isValidFormat) {
                        setInputValidity(input, false, "El carnet debe tener entre 4 y 11 caracteres.");
                        return;
                    }

                    // Only make API call if the value has changed from the original
                    if (value === originals.carnet) {
                        resetFieldState(input);
                        touchedFields.delete(input.id);
                        return;
                    }

                    // API call to validate if carnet exists
                    fetch(`/validate-carnet?value=${encodeURIComponent(value)}`)
                        .then(response => response.json())
                        .then(data => {
                            setInputValidity(input, !data.exists, '', "Este carnet ya está registrado.");
                        });
                }

                // Validate celular input by checking for 8 digits and API uniqueness check
                function validateCelularInput(input) {
                    const value = input.value.replace(/\D/g, ''); // Remove non-digit characters
                    const isValidFormat = value.length === 8;

                    if (!isValidFormat) {
                        setInputValidity(input, false, "El número de celular debe tener 8 dígitos.");
                        return;
                    }

                    // Only make API call if the value has changed from the original
                    if (value === originals.celular) {
                        resetFieldState(input);
                        touchedFields.delete(input.id);
                        return;
                    }

                    // API call to validate if celular exists
                    fetch(`/validate-celular?value=${encodeURIComponent(value)}`)
                        .then(response => response.json())
                        .then(data => {
                            setInputValidity(input, !data.exists, '',
                                "Este número de celular ya está registrado.");
                        });
                }

                /* ------------- Event Listeners ------------- */

                // Add event listeners to input fields with debounce
                fields.nombre.addEventListener('input', debounce(() => {
                    touchedFields.add('nombre');
                    validateTextInput(fields.nombre);
                }, 100));

                fields.papellido.addEventListener('input', debounce(() => {
                    touchedFields.add('papellido');
                    validateTextInput(fields.papellido);
                }, 100));

                fields.sapellido.addEventListener('input', debounce(() => {
                    touchedFields.add('sapellido');
                    validateTextInput(fields.sapellido);
                }, 100));

                fields.carnet.addEventListener('input', debounce(() => {
                    touchedFields.add('carnet');
                    validateCarnetInput(fields.carnet);
                }, 100));

                fields.celular.addEventListener('input', debounce(() => {
                    touchedFields.add('celular');
                    validateCelularInput(fields.celular);
                }, 100));

                // Prevent form submission if fields are invalid
                document.getElementById("update-form").addEventListener("submit", function(event) {
                    if (updateBtn.disabled) {
                        event.preventDefault();
                    }
                });

                // Add event listener for the reset button
                resetBtn.addEventListener('click', function() {
                    resetToOriginalValues();
                });

                // Initial validation on page load
                validateAllFields();
            });
        </script>

    @endsection
