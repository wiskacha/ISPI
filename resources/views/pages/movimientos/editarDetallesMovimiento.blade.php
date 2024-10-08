@extends('layouts.backend')

@section('css')
    <!-- Add necessary CSS here -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Editar Detalles
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Movimiento
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Movimiento</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editar Movimiento
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editar Detalles
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ $movimiento->codigo }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de Detalles
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPr = 0; @endphp <!-- Initialize the total -->
                        @foreach ($detalles as $index => $detalle)
                            <tr>
                                <td class="text-center hide-on-small">{{ $loop->index + 1 }}</td>
                                <td class="text-muted">{{ $detalle->producto->nombre }}</td>
                                <td class="text-muted">{{ $detalle->producto->codigo }}</td>
                                <td class="text-muted">{{ $detalle->cantidad }}</td>
                                <td class="text-muted">{{ $detalle->precio }}</td>
                                <td class="text-muted">
                                    {{ $detalle->total }}
                                    @php
                                        $totalPr += $detalle->total;
                                    @endphp <!-- Add the subtotal to the running total -->
                                </td>
                                <td class="text-muted">
                                    <!-- Add an edit button here -->
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $detalle->id_detalle }}" title="Editar Detalle">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                        <!-- Edit button -->
                                    </button>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $detalle->id_detalle }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-block-vcenter">Registro de Cliente
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="updateDet-form"
                                                        action="{{ route('movimientos.guardarDetalles', $detalle->id_detalle) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="table-responsive">
                                                            <table id="detalle-table" class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Producto</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Precio</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <td>
                                                                        <select class="js-example-basic-single form-control form-control-lg" id="producto"
                                                                        name="producto" required>
                                                                        <option value="">Seleccione un Producto</option>
                                                                        @foreach ($productos as $producto)
                                                                            <option class="col-12" value="{{ $producto->id_producto }}"
                                                                                {{ $detalle->producto->id_producto == $producto->id_producto ? 'selected' : '' }}>
                                                                                [{{ $producto->codigo }}]{{ $producto->nombre }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="cantidad" min="0" value="0" />
                                                                    </td>
                                                                    <td class="precio" value="">0</td>
                                                                    <td class="subtotal">0</td>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Registrar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add a delete button here -->
                                    <form method="POST"
                                        action="{{ route('movimientos.eliminarDetalle', ['id_movimiento' => $movimiento->id_movimiento, 'id_detalle' => $detalle->id_detalle]) }}"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Está seguro que desea eliminar el producto {{ $producto->nombre }}?');">
                                            <i class="fa fa-trash"></i><small class="hide-on-small"> Eliminar</small>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right" colspan="5"><strong>TOTAL</strong></td>
                            <td colspan="1">{{ number_format($totalPr, 2) }}</td>
                            <!-- Display the total -->
                        </tr>
                    </tfoot>
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

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for product selection
            $('.select-producto').select2();
        });
    </script>
@endsection
