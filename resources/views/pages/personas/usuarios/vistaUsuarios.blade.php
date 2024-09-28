<!-- resources/views/pages/vistaClientes.blade.php -->

@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        @media (max-width: 605px) {
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
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Vista de Usuarios
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Usuarios Registrados
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Personas</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Vista de Usuarios
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de USUARIOS <small></small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                <thead>
                    <tr>
                        <th class="text-center hide-on-small" style="width: 5%;">#</th>
                        <th style="width: 10%;">Nick/Email</th>
                        <th style="width: 10%;">Dueño</th>
                        <th class="text-center" style="width: 10%;">Acciones</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $index => $usuario)
                        <tr>
                            <td class="text-center hide-on-small">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $usuario->NICKEMAIL }}</td>
                            <td class="text-muted">{{ $usuario->DUEÑO }}</td> <!-- Aquí mostramos el dueño -->
                            <td class="text-center">
                                <!-- Form to handle the delete action -->
                                <form method="POST" action="{{ route('user.destroy', $usuario->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Está seguro que desea eliminar a {{ $usuario->NICKEMAIL }}?');">
                                        <i class="fa fa-trash"></i>
                                        <span class="hide-on-small">Eliminar</span>
                                    </button>
                                </form>

                                <!-- Button to handle the edit action -->
                                <a href="{{ route('personas.usuarios.editUsuario', $usuario) }}" class="btn btn-sm btn-primary">
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
@endsection
