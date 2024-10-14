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

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])
@endsection


@section('content')
    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastContainer">
            @if (session('error'))
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th style="width: 15%;">Carnet</th>
                            <th style="width: 15%;">Nombre</th>
                            <th class="text-center" style="width: 10%;">Teléfono</th> <!-- New column for actions -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $index => $persona)
                            <tr>
                                <td class="text-center hide-on-small">
                                    {{ $index + 1 }}
                                </td>
                                <td class="text-muted">
                                    {{ $persona->carnet }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $persona->papellido }} {{$persona->sapellido }} {{ $persona->nombre }}
                                    @if ($persona->usuario)
                                        <i class="fa fa-check-circle text-success" title="Verified User"></i>
                                    @endif
                                </td>
                                <td class="text-muted hide-on-small">{{ $persona->celular ?? 'N/A' }}</td>
                            </tr>
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

@endsection
