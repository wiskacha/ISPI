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
    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastContainer">
            @if (session('success'))
                <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @elseif(session('error'))
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Vista de Clientes
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Personas Registradas
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Clientes
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Vista de Clientes
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded m-2">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de Clientes
            </h3>
        </div>
        <div class="block-content block-content-full ">
            <!-- Form to handle the checkbox change -->
            <form method="GET" action="{{ route('personas.clientes.vistaClientes') }}" id="filterForm">
                <div class="d-flex justify-content-center mb-3">
                    <div class="form-check form-switch me-3">
                        <input class="form-check-input" type="checkbox" name="exclude_users" id="excludeUsers"
                            {{ request('exclude_users') ? 'checked' : '' }}>
                        <label class="form-check-label" for="excludeUsers">Excluir Empleados</label>
                    </div>
                    <div class="ms-3">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#modal-block-vcenter">
                            <i class="fa fa-plus"></i>
                            <span class="d-none d-sm-inline">Registrar Cliente</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th style="width: 15%;">Nombre</th>
                            <th style="width: 15%;">Carnet</th>
                            <th class="hide-on-small" style="width: 15%;">Celular</th>
                            <th class="text-center" style="width: 10%;">Acciones</th> <!-- New column for actions -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $index => $persona)
                            <tr>
                                <td class="text-center hide-on-small">{{ $index + 1 }}</td>
                                <td class="fw-semibold">
                                    {{ $persona->NOMBRE }}
                                    @if ($persona->has_user)
                                        <i class="fa fa-check-circle text-success" title="Verified User"></i>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $persona->CARNET }}</td>
                                <td class="text-muted hide-on-small">{{ $persona->CELULAR ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <!-- Form to handle the delete action -->
                                    <form method="POST" action="{{ route('persona.destroy', $persona->id_persona) }}"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está seguro que desea eliminar a {{ $persona->NOMBRE }}?');">
                                            <i class="fa fa-trash"></i>
                                            <span class="hide-on-small">Eliminar</span>
                                        </button>
                                    </form>

                                    <!-- Button to handle the edit action -->
                                    <a href="{{ route('persona.editCliente', $persona) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                        <span class="hide-on-small">Editar</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-block-vcenter" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-block-vcenter">Registro de Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/personas/clientes/register" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombres" required>
                                    <label for="nombre">Nombres</label>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="papellido" name="papellido"
                                        placeholder="Primer Apellido" required>
                                    <label for="papellido">Primer Apellido</label>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="sapellido" name="sapellido"
                                        placeholder="Segundo Apellido" required>
                                    <label for="sapellido">Segundo Apellido</label>
                                    <div class="invalid-feedback">Este campo es opcional.</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="carnet" name="carnet"
                                        placeholder="Cédula de Identidad" required>
                                    <label for="carnet">Cédula de Identidad</label>
                                    <div class="invalid-feedback">Este campo es obligatorio.</div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-5 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="celular" name="celular"
                                    placeholder="Celular" required>
                                <label for="celular">Celular</label>
                                <div class="invalid-feedback">Este campo es obligatorio.</div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            // Handle form submission on checkbox change
            $('#excludeUsers').on('change', function() {
                $('#filterForm').submit();
            });
        });
    </script>
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
