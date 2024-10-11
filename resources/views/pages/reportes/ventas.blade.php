@extends('layouts.backend')

@section('css')
    <style>
        @media (max-width: 1328px) {
            .hide-on-small {
                display: none;
            }
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle the collapse for the detalles rows
            $('.clickable-row').click(function() {
                const target = $(this).data('target');
                $(target).collapse('toggle');
            });
            // Button to expand/collapse all desglose items
            $('#toggle-all').click(function() {
                const allDesglose = $('.desglose');
                if (allDesglose.is(':visible')) {
                    allDesglose.collapse('hide');
                } else {
                    allDesglose.collapse('show');
                }
            });
        });
    </script>
@endsection

@section('content')

    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Reporte
            </h3>
        </div>
        <div class="block-content block-content-full">

            <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
                <div class="block-header block-header-default clickable-row" data-target="#contenido-tabla"
                    style="cursor: pointer;">
                    <h3 class="block-title">
                        DESGLOSE DE MOVIMIENTOS
                    </h3>
                </div>
                <div id="contenido-tabla" class="block-content block-content-full collapse">
                    <div class="ms-3">

                        <form action="{{ route('reportes.imprimirDesglose') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="movimiento_ids"
                                value="{{ json_encode($movimientos->pluck('id_movimiento')) }}">
                            <!-- Pass only the IDs of movimientos -->
                            <button type="submit" class="btn btn-primary">Generar PDF</button>
                        </form>
                    </div>

                    <div class="ms-auto d-flex justify-content-end">
                        <button id="toggle-all" class="btn btn-alt-warning">
                            Expandir / Colapsar Todos
                        </button>
                    </div>
                    <hr />
                    <!-- Check if there are any movimientos to display -->
                    @if ($movimientos->isEmpty())
                        <div class="alert alert-info">
                            No se encontraron movimientos que coincidan con los criterios de búsqueda.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Tipo</th>
                                        <th>Almacén</th>
                                        <th>Operador</th>
                                        <th>Cliente</th>
                                        <th>Recinto</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Total Productos</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movimientos as $movimiento)
                                        <tr>
                                            <td>{{ $movimiento->codigo }}</td>
                                            <td>{{ $movimiento->tipo }}</td> <!-- ENTRADA or SALIDA -->
                                            <td>{{ $movimiento->almacene->nombre ?? 'N/A' }}</td>
                                            <!-- Assumes 'almacene' relationship exists -->
                                            <td>{{ $movimiento->usuario->persona->carnet ?? 'N/A' }}</td>
                                            <!-- Assumes 'operador' relationship exists -->
                                            <td>{{ $movimiento->cliente->carnet ?? 'N/A' }}</td>
                                            <!-- Assumes 'cliente' relationship exists for VENTAS -->
                                            <td>{{ $movimiento->recinto->nombre ?? 'N/A' }}</td>
                                            <!-- Assumes 'recinto' relationship exists for VENTAS -->
                                            <td>{{ $movimiento->persona->carnet ?? 'N/A' }}</td>
                                            <!-- Assumes 'recinto' relationship exists for VENTAS -->
                                            <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $movimiento->detalles->count() }}</td> <!-- Count of Detalles -->
                                            @if ($movimiento->tipo == 'ENTRADA')
                                                <td>{{ number_format($movimiento->detalles->sum('total'), 2) }}</td>
                                                <td>No Aplica</td>
                                            @else
                                                <td>{{ number_format($movimiento->cuotas->sum('monto_pagar'), 2) }}</td>
                                                @php $cuotasST = ""; @endphp
                                                @if ($movimiento->cuotas->count() > 0)
                                                    @php $cuotasST = "COMPLETO"; @endphp
                                                    @foreach ($movimiento->cuotas as $cuota)
                                                        @if ($cuota->condicion == 'PENDIENTE')
                                                            @php $cuotasST="PENDIENTE"; @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $cuotasST }}</td>
                                                @else
                                                    <td>No Asignadas</td>
                                                @endif
                                            @endif
                                            <!-- Sum of Detalle totals -->
                                        </tr>
                                        <tr class="clickable-row" data-toggle="collapse"
                                            data-target="#detalles-{{ $movimiento->id_movimiento }}">
                                            <td colspan="11">Detalles ↕</td>
                                        </tr>
                                        <!-- Expandable row for product details -->
                                        <tr id="detalles-{{ $movimiento->id_movimiento }}" class="collapse desglose">
                                            <td colspan="11">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Empresa</th>
                                                                <th>Producto</th>
                                                                <th>Cantidad</th>
                                                                <th>Precio Unitario</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $totalP=0; @endphp
                                                            @foreach ($movimiento->detalles as $detalle)
                                                                <tr>
                                                                    <td>{{ $detalle->producto->empresa->nombre }}</td>
                                                                    <td>{{ $detalle->producto->nombre }}</td>
                                                                    <td>{{ $detalle->cantidad }}</td>
                                                                    <td>{{ number_format($detalle->precio, 2) }}</td>
                                                                    <td>
                                                                        {{ number_format($detalle->total, 2) }}
                                                                        @php $totalP += $detalle->total @endphp
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3"></td>
                                                                <td>TOTAL: </td>
                                                                <td>{{ number_format($totalP, 2) }}</td>
                                                                <!-- Sum of Detalle totals -->
                                                            </tr>

                                                            @if ($movimiento->cuotas->count() > 0)
                                                                <tr class="clickable-row" data-toggle="collapse"
                                                                    data-target="#cuotas-{{ $movimiento->id_movimiento }}">
                                                                    <td colspan="11">Cuotas ↕</td>
                                                                </tr>
                                                                <tr id="cuotas-{{ $movimiento->id_movimiento }}"
                                                                    class="collapse desglose">
                                                                    <td colspan="10">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered">
                                                                                <thead class="thead-light">
                                                                                    <tr>
                                                                                        <th>Concepto</th>
                                                                                        <th>Código</th>
                                                                                        <th>Fecha V.</th>
                                                                                        <th>M. Pagar</th>
                                                                                        <th>M. Pagado</th>
                                                                                        <th>M. Pendiente</th>
                                                                                        <th>Condición</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @php
                                                                                        $total_mPgr = 0;
                                                                                        $total_mPdo = 0;
                                                                                        $total_mAde = 0;
                                                                                        $estado = true;
                                                                                    @endphp
                                                                                    @foreach ($movimiento->cuotas as $cuota)
                                                                                        <tr>
                                                                                            <td>{{ $cuota->concepto }}</td>
                                                                                            <td>{{ $cuota->codigo }}</td>
                                                                                            <td>{{ date('d/M/Y', strtotime($cuota->fecha_venc)) }}
                                                                                            </td>
                                                                                            <td>{{ $cuota->monto_pagar }}
                                                                                            </td>
                                                                                            <td>{{ $cuota->monto_pagado }}
                                                                                            </td>
                                                                                            <td>{{ $cuota->monto_adeudado }}
                                                                                            </td>
                                                                                            <td>{{ $cuota->condicion }}
                                                                                            </td>
                                                                                            @php
                                                                                                $total_mPgr +=
                                                                                                    $cuota->monto_pagar;
                                                                                                $total_mPdo +=
                                                                                                    $cuota->monto_pagado;
                                                                                                $total_mAde +=
                                                                                                    $cuota->monto_adeudado;
                                                                                                $estado =
                                                                                                    $estado &&
                                                                                                    $cuota->condicion ==
                                                                                                        'PAGADA';
                                                                                            @endphp
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <td colspan="2"></td>
                                                                                        <td colspan="0"><strong>T.
                                                                                                Cuotas:</strong></td>
                                                                                        <td>{{ number_format($total_mPgr, 2) }}
                                                                                        </td>
                                                                                        <td>{{ number_format($total_mPdo, 2) }}
                                                                                        </td>
                                                                                        <td>{{ number_format($total_mAde, 2) }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($estado)
                                                                                                <span
                                                                                                    style="color: limegreen"><strong>COMPLETO</strong></span>
                                                                                            @else
                                                                                                <span
                                                                                                    style="color: crimson"><strong>PENDIENTE</strong></span>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <hr>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
