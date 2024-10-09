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
                        Editar Movimiento
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
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div id="content-to-pdf" class="content content-boxed">
        <!-- Product Edit -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Editar Movimiento</h3>
                <div class="ms-3">
                    <a href="{{ route('movimientos.previewRecibo', $movimiento->id_movimiento) }}" target="_blank">
                        <button id="generarReciboBtn" type="button" class="btn btn-sm btn-alt-info">
                            <i class="fa fa-file-pdf"></i>
                            <i class="fa fa-eye"></i>
                            <span class="d-none d-sm-inline">Previsualizar Recibo</span>
                        </button>
                    </a>
                </div>
                <div class="ms-3">
                    <a href="{{ route('movimientos.downloadRecibo', $movimiento->id_movimiento) }}" target="_blank">
                        <button id="descargarReciboBtn" type="button" class="btn btn-sm btn-alt-success">
                            <i class="fa fa-file-pdf"></i>
                            <i class="fa fa-download"></i>
                            <span class="d-none d-sm-inline">Descargar Recibo</span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="block-content">
                <form id="movimiento-edit" action="{{ route('movimientos.update', $movimiento->id_movimiento) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Main form fields (Two columns) -->
                    <div class="row push">
                        <div class="col-lg-12 col-xl-12">

                            <div class="row">
                                <div class="col-ms-12 col-md-6">
                                    <!-- Código -->
                                    <div class="mb-4">
                                        <label class="form-label" for="codigo">Código: </label>
                                        <h2>{{ $movimiento->codigo }}</h2>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Fecha -->
                                    <div class="mb-4">
                                        <label class="form-label" for="fecha">Fecha de Operación: </label>
                                        <h2>{{ $movimiento->fecha }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-ms-5 col-md-6">
                                    <!-- Glose -->
                                    <div class="mb-4">
                                        <label class="form-label" for="glose">Glose</label>
                                        <textarea type="text" class="form-control" id="glose" name="glose">{{ old('glose', $movimiento->glose) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-ms-3 col-md-2 ">
                                    <!-- Tipo -->
                                    <div class="mb-4">
                                        <label class="form-label" for="tipo">Tipo</label>
                                        <h2>{{ $movimiento->tipo }}</h2>
                                    </div>
                                </div>
                                <div class="col-md-4" style="align-items: right;">
                                    <!-- Operador -->
                                    <div class="mb-4">
                                        <label class="form-label" for="operador">Operador</label>
                                        <h2>[{{ $movimiento->usuario->persona->carnet }}]
                                            {{ $movimiento->usuario->persona->papellido }}</h2>
                                    </div>
                                </div>
                            </div>

                            <!-- Add a divider for the next fields -->
                            <hr>
                            <div class="row">
                                @if ($movimiento->tipo == 'SALIDA')
                                    <div class="col-md-6">
                                        <!-- Cliente -->
                                        <div class="mb-4">
                                            <label class="form-label" for="cliente">Cliente</label></br>
                                            <select
                                                class="select-optionals js-example-basic-single form-control form-control-lg"
                                                id="cliente" name="cliente">
                                                <option value="">Seleccione un Cliente</option>
                                                <!-- Opción vacía por defecto -->
                                                @foreach ($clientes as $cliente)
                                                    <option class="col-12" value="{{ $cliente->id_persona }}"
                                                        {{ $movimiento->id_cliente == $cliente->id_persona ? 'selected' : '' }}>
                                                        [{{ $cliente->carnet }}] {{ $cliente->papellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cliente')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Recinto -->
                                        <div class="mb-4">
                                            <label class="form-label" for="recinto">Recinto</label></br>
                                            <select
                                                class="select-optionals js-example-basic-single form-control form-control-lg"
                                                id="recinto" name="recinto">
                                                <option value="">Seleccione un Recinto</option>
                                                <!-- Opción vacía por defecto -->
                                                @foreach ($recintos as $recinto)
                                                    <option class="col-12" value="{{ $recinto->id_recinto }}"
                                                        {{ $movimiento->id_recinto == $recinto->id_recinto ? 'selected' : '' }}>
                                                        {{ $recinto->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('recinto')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @elseif ($movimiento->tipo == 'ENTRADA')
                                    <div class="col-md-6">
                                        <!-- Proveedor -->
                                        <div class="mb-4">
                                            <label class="form-label" for="proveedor">Proveedor</label></br>
                                            <select class="js-example-basic-single form-control form-control-lg"
                                                id="proveedor" name="proveedor" required>
                                                @foreach ($proveedores as $proveedor)
                                                    <option class="col-12" value="{{ $proveedor->id_persona }}"
                                                        {{ $movimiento->id_proveedor == $proveedor->id_persona ? 'selected' : '' }}>
                                                        [{{ $proveedor->carnet }}] {{ $proveedor->papellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('proveedor')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="almacene">Almacen</label></br>
                                    <select class="js-example-basic-single form-control form-control-lg" id="almacene"
                                        name="almacene" required>
                                        <option value="">Seleccione un Almacen</option>
                                        @foreach ($almacenes as $almacene)
                                            <option class="col-12" value="{{ $almacene->id_almacen }}"
                                                {{ $movimiento->id_almacen == $almacene->id_almacen ? 'selected' : '' }}>
                                                {{ $almacene->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <hr>
                            <!-- Update Button -->
                            <div class="col-12 col-lg-3 ms-auto text-lg-end">
                                <button type="button" class="btn btn-alt-primary w-100 w-lg-auto"
                                    style="margin-bottom: 1rem;" data-bs-toggle="modal"
                                    data-bs-target="#confirmationModal">Actualizar</button>
                            </div>

                        </div>
                </form>

                <hr>
                <small>*La manipulación/cambio de datos a partir de este punto toma en cuenta la información guardada,
                    asegúrese de 'Actualizar' la parte superior antes de continuar.</small>
                <!-- Detalles Section (Separate Block) -->
                <div class="block block-bordered mt-5">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Lista de Detalles
                        </h3>
                        <div class="ms-3">
                            <button id="editarDetallesBtn" type="button" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                                <span class="d-none d-sm-inline">Editar Detalles</span>
                            </button>

                            <script>
                                document.getElementById('editarDetallesBtn').addEventListener('click', function() {
                                    // Obtener el ID del movimiento
                                    var movimientoId = {{ $movimiento->id_movimiento }};

                                    // Llamada AJAX
                                    fetch(`/movimientos/${movimientoId}/check-cuotas`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.exists) {
                                                // Mostrar el modal si existen cuotas relacionadas
                                                document.getElementById('cuotasAlertMessage').innerText = data.message;
                                                var cuotasAlertModal = new bootstrap.Modal(document.getElementById('cuotasAlertModal'));
                                                cuotasAlertModal.show();
                                            } else {
                                                // Redirigir a la página de edición si no hay cuotas
                                                window.location.href = `/movimientos/${movimientoId}/editDetalles`;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error en la llamada AJAX:', error);
                                        });
                                });
                            </script>

                        </div>
                    </div>
                    @if ($detalles->count() > 0)
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
                    @else
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-sm-10 col-md-8">
                                <br>
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <small>
                                        <p>No hay detalles asignados a este movimiento</p>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($movimiento->tipo == 'SALIDA')
                    <!-- Cuotas Section (Separate Block) -->
                    <div class="block block-bordered mt-5">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Lista de Cuotas
                            </h3>
                            @if ($cuotas->count() > 0)
                                <div class="ms-3">
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#eliminarCuotasModal">
                                        <i class="fa fa-ban"></i>
                                        <span class="d-none d-sm-inline">Eliminar Cuotas</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        @if ($cuotas->count() > 0)
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                                            <th>Código</th>
                                            <th>Concepto</th>
                                            <th>Fecha V.</th>
                                            <th>Monto Pagar</th>
                                            <th>Monto Pagado</th>
                                            <th>Monto Pendiente</th>
                                            <th>Estado</th>
                                            <th style="width: 15%;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_mPgr = 0;
                                            $total_mPdo = 0;
                                            $total_mAde = 0;
                                            $estado = true;
                                        @endphp <!-- Initialize the total -->
                                        @foreach ($cuotas as $index => $cuota)
                                            <tr>
                                                <td class="text-center hide-on-small">{{ $cuota->numero }}</td>
                                                <td class="text-muted">{{ $cuota->codigo }}</td>
                                                <td class="text-muted">{{ $cuota->concepto }}</td>
                                                <td class="text-muted">{{ $cuota->fecha_venc }}</td>
                                                <td class="text-muted">{{ $cuota->monto_pagar }}
                                                    @php
                                                        $total_mPgr += $cuota->monto_pagar;
                                                    @endphp
                                                </td>

                                                <td class="text-muted">{{ $cuota->monto_pagado }}
                                                    @php
                                                        $total_mPdo += $cuota->monto_pagado;
                                                    @endphp
                                                </td>
                                                <td class="text-muted">{{ $cuota->monto_adeudado }}
                                                    @php
                                                        $total_mAde += $cuota->monto_adeudado;
                                                    @endphp
                                                </td>
                                                <td class="text-muted">{{ $cuota->condicion }}
                                                    @php
                                                        if ($cuota->condicion == 'PAGADA') {
                                                            $estado *= true;
                                                        } else {
                                                            $estado *= false;
                                                        }
                                                    @endphp
                                                </td>
                                                <td class="text-muted" style="text-align: center">
                                                    <div class="btn-group">
                                                        @if ($cuota->monto_pagado > 0)
                                                            <!-- Reset Cuota Button -->
                                                            <button type="button" class="btn btn-sm btn-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#resetModal{{ $cuota->id_cuota }}">
                                                                <i class="fa fa-undo"></i>
                                                                <span class="hide-on-small">Reset</span>
                                                            </button>
                                                        @endif
                                                        @if ($cuota->condicion == 'PENDIENTE')
                                                            <!-- Pagar Cuota Button -->
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#payModal{{ $cuota->id_cuota }}">
                                                                <i class="fa fa-plus"></i>
                                                                <span class="hide-on-small">Pagar</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Reset Modal -->
                                            <div class="modal fade" id="resetModal{{ $cuota->id_cuota }}" tabindex="-1"
                                                aria-labelledby="resetModalLabel{{ $cuota->id_cuota }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="resetModalLabel{{ $cuota->id_cuota }}">Confirmar Reset
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Está seguro de que desea resetear esta cuota?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <a href="{{ route('movimientos.resetCuota', $cuota->id_cuota) }}"
                                                                class="btn btn-warning">Confirmar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pay Modal -->
                                            <div class="modal fade" id="payModal{{ $cuota->id_cuota }}" tabindex="-1"
                                                aria-labelledby="payModalLabel{{ $cuota->id_cuota }}" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="payModalLabel{{ $cuota->id_cuota }}">Confirmar Pago
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Está seguro de que desea realizar el pago de esta cuota?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <a href="{{ route('movimientos.payCuota', $cuota->id_cuota) }}"
                                                                class="btn btn-success">Confirmar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="text-align: right" colspan="4"><strong>TOTAL</strong></td>
                                            <!-- Display the respective totals -->
                                            <td colspan="1"><strong>{{ number_format($total_mPgr, 2) }}</strong></td>
                                            <td colspan="1"><strong>{{ number_format($total_mPdo, 2) }}</strong></td>
                                            <td colspan="1"><strong>{{ number_format($total_mAde, 2) }}</strong></td>
                                            <td colspan="1" style="text-align: center">
                                                @if ($estado)
                                                    <span class="badge bg-success">COMPLETO</span>
                                                @else
                                                    <span class="badge bg-danger">PENDIENTE</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="row justify-content-center py-sm-3 py-md-5">
                                <div class="col-sm-10 col-md-8">
                                    <br>
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <small>
                                            <p>No hay cuotas asignadas a este movimiento</p>
                                        </small>
                                    </div>
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <form
                                            action="{{ route('movimientos.asignarCuotas', $movimiento->id_movimiento) }}"
                                            method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                style="margin: 0 1rem; display: flex; align-items: center;"><i
                                                    class="fa fa-plus"></i>
                                                <span class="d-none d-sm-inline">Añadir Cuotas</span>
                                            </button>
                                        </form>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($cuotas->count() > 0)
                    <!-- Detailed Totals Section (Separate Block) -->
                    <div class="block block-bordered mt-5">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Totales Detallados</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Productos</td>
                                        <td> {{ number_format($totalPr, 2) }}</td>
                                    </tr>
                                    <tr>
                                        @if ($total_mPgr > $totalPr)
                                            <td>Aditivo</td>
                                            <td>+{{ number_format($total_mPgr - $totalPr, 2) }}</td>
                                        @else
                                            <td>Descuento</td>
                                            <td>-{{ number_format($totalPr - $total_mPgr, 2) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total Cuotas</td>
                                        <td>{{ number_format($total_mPgr, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Changelog Section (Separate Block) -->
                <div class="block block-bordered mt-5">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Changelog</h3>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-sm-10 col-md-8">
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <small>
                                        <p>No hay cambios</p>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <!-- Dangerous Delete Button to Open Modal -->
                <div style="display: flex; justify-content: center; align-items: center;">
                    <button type="button" class="col-md-3 btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#eliminarMovimientoModal"
                        style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                        <i class="fa fa-trash"></i>
                        <span>ELIMINAR MOVIMIENTO</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Alerta -->
    <div class="modal fade" id="cuotasAlertModal" tabindex="-1" aria-labelledby="cuotasAlertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="cuotasAlertModalLabel">Advertencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="cuotasAlertMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Eliminar Cuotas Modal -->
    <div class="modal fade" id="eliminarCuotasModal" tabindex="-1" aria-labelledby="elliminarCuotasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarCuotasModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('movimientos.cuotasDestroy', $movimiento->id_movimiento) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        ¿Está seguro de que desea eliminar las cuotas?

                        <!-- Checkbox para confirmar -->
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="confirmarEliminacionCCheckbox" required>
                            <label class="form-check-label" for="confirmarEliminacionCCheckbox">
                                Confirmo que deseo eliminar este movimiento.
                            </label>
                            <small>Esta acción es irreversible</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <!-- El botón de eliminar se enviará solo si la checkbox está marcada -->
                        <button type="submit" class="btn btn-danger">Eliminar Movimiento</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Eliminar Movimiento Modal -->
    <div class="modal fade" id="eliminarMovimientoModal" tabindex="-1" aria-labelledby="eliminarMovimientoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarMovimientoModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('movimientos.destroy', $movimiento->id_movimiento) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        ¿Está seguro de que desea eliminar el movimiento?

                        <!-- Checkbox para confirmar -->
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="confirmarEliminacionCheckbox" required>
                            <label class="form-check-label" for="confirmarEliminacionCheckbox">
                                Confirmo que deseo eliminar este movimiento.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <!-- El botón de eliminar se enviará solo si la checkbox está marcada -->
                        <button type="submit" class="btn btn-danger">Eliminar Movimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Actualización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas actualizar este movimiento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmUpdateButton">Confirmar</button>
                </div>
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
        document.getElementById('confirmUpdateButton').addEventListener('click', function() {
            // Envía el formulario cuando el botón de confirmación sea presionado
            document.getElementById('movimiento-edit').submit();
        });
    </script>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script></script>
    <script>
        $(document).ready(function() {
            // Apply Select2 to the ID Empresa field
            $('.js-example-basic-single:not(.select-optionals)').select2({
                allowClear: false,

            });

            $('.select-optionals').select2({
                placeholder: 'No asignado...',
            });
        });
    </script>
@endsection
