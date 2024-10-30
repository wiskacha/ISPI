@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        @media (max-width: 1328px) {
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

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (!confirmDeleteModal) {
                return;
            }

            confirmDeleteModal.addEventListener('show.bs.modal', function(event) {

                const button = event.relatedTarget;
                const recintoName = button.getAttribute('data-recinto-name');
                const recintoId = button.getAttribute('data-recinto-id');

                // Actualizar el contenido del modal
                const modalRecintoName = confirmDeleteModal.querySelector('#recinto-name');
                modalRecintoName.textContent = recintoName;

                // Actualizar la acción del formulario usando la ruta nombrada
                const deleteForm = confirmDeleteModal.querySelector('#deleteRecintoForm');
                const newAction = `{{ route('recintos.destroy', 'id') }}`.replace('id', recintoId);
                deleteForm.action = newAction;

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
                        Vista de Recintos
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Lugares (Recintos)
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Recintos</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Vista de Recintos
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de Recintos
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 30%;">Dirección</th>
                            <th style="width: 10%;">Tipo</th>
                            <th style="width: ">Teléfono</th>
                            <th class="text-center" style="width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recintos as $index => $recinto)
                            <tr>
                                <td class="text-center hide-on-small">{{ $index + 1 }}</td>
                                <td class="fw-semibold">
                                    {{ $recinto->nombre }}
                                </td>
                                <td class="text-muted">{{ $recinto->direccion }}</td>
                                <td class="text-muted">{{ $recinto->tipo }}</td>
                                <td class="text-muted">{{ $recinto->telefono }}</td>
                                <td class="text-center">
                                    <!-- Button to handle the edit action -->
                                    <a href="{{ route('recintos.edit', $recinto) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                        <span class="hide-on-small">Editar</span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal" data-recinto-name="{{ $recinto->nombre }}"
                                        data-recinto-id="{{ $recinto->id_recinto }}">
                                        <i class="fa fa-trash"></i>
                                        <span class="hide-on-small">Eliminar</span>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($errors->any() || session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    @endif
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar a <strong id="recinto-name"></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteRecintoForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
