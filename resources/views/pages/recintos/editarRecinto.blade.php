@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
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
    <!-- editarRecinto.blade.php -->

    <!-- Modal Structure -->
    @include('partials.confirmation-Recintosmodal', ['recinto' => $recinto])

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Editar Recinto</h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Recintos</li>
                        <li class="breadcrumb-item" aria-current="page">Editar Recinto</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded m-2">
        <div class="block-header block-header-default">
            <h3 class="block-title">Editar Recinto</h3>
        </div>
        <div class="container mt-4">
            <div class="card-body">
                <form id="update-form" action="{{ route('recintos.update', $recinto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre del Recinto</label>
                            <input type="text" id="nombre" name="nombre"
                                value="{{ old('nombre', $recinto->nombre) }}" class="form-control" required>
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" id="direccion" name="direccion"
                                value="{{ old('direccion', $recinto->direccion) }}" class="form-control" required>
                            @error('direccion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" id="tipo" name="tipo" value="{{ old('tipo', $recinto->tipo) }}"
                                class="form-control">
                            @error('tipo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="number" id="telefono" name="telefono"
                                value="{{ old('telefono', $recinto->telefono) }}" class="form-control">
                            @error('telefono')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                                <a href="{{ route('recintos.vista') }}" class="btn btn-secondary"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fields = {
                nombre: document.getElementById("nombre"),
                direccion: document.getElementById("direccion"),
                tipo: document.getElementById("tipo"),
                telefono: document.getElementById("telefono")
            };
            const updateBtn = document.getElementById("update-btn");
            const resetBtn = document.getElementById("reset-btn");
            const noChangesText = document.getElementById("no-changes-text");
            const noChangesIcon = document.getElementById("no-changes-icon");

            // Original values for comparison
            const originals = {
                nombre: "{{ $recinto->nombre }}",
                direccion: "{{ $recinto->direccion }}",
                tipo: "{{ $recinto->tipo }}",
                telefono: "{{ $recinto->telefono }}"
            };

            let touchedFields = new Set();
            let debounceTimeouts = {};

            // Add the validation logic similar to personas to check for form field changes and enable or disable buttons
            const checkChanges = () => {
                let hasChanges = false;
                touchedFields.forEach(field => {
                    if (fields[field].value.trim() !== originals[field]) {
                        hasChanges = true;
                    }
                });

                updateBtn.disabled = !hasChanges;
                resetBtn.disabled = !hasChanges;

                if (hasChanges) {
                    noChangesText.style.display = "none";
                    noChangesIcon.style.display = "none";
                } else {
                    noChangesText.style.display = "inline";
                    noChangesIcon.style.display = "none";
                }
            };

            // Validation event listener logic
            Object.keys(fields).forEach(field => {
                fields[field].addEventListener("input", (e) => {
                    touchedFields.add(field);
                    checkChanges();
                });
            });

            resetBtn.addEventListener("click", () => {
                Object.keys(fields).forEach(field => {
                    fields[field].value = originals[field];
                });
                touchedFields.clear();
                checkChanges();
            });

            checkChanges();
        });
    </script>
@endsection
