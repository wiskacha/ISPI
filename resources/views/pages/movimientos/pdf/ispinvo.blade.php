<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Movimiento de Inventario</title>

    <style>
        /* Reset y variables */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .page-break {
            page-break-after: always;
        }

        :root {
            --primary-color: #333;
            --secondary-color: #555;
            --border-color: #ddd;
            --highlight-color: #f5f5f5;
            --header-color: #e9ecef;
            --footer-color: #f8f9fa;
            --table-border: #dee2e6;
        }

        /* Estilos base */
        .invoice-box {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 1.4;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: var(--secondary-color);
        }

        /* Tablas */
        .invoice-box table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid var(--table-border);
        }

        .invoice-box table td {
            padding: 8px;
            vertical-align: top;
            border: 1px solid var(--table-border);
        }

        /* Header */
        .header-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        .invoice-info {
            text-align: right;
            font-size: 0.9em;
        }

        /* Información principal */
        .main-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        /* Tablas de productos y cuotas */
        .table-header {
            background: var(--header-color);
            font-weight: bold;
        }

        .table-header td {
            padding: 10px 8px;
            border-bottom: 2px solid var(--table-border);
        }

        thead tr {
            background-color: var(--header-color);
            font-weight: bold;
        }

        thead td {
            border-bottom: 2px solid var(--table-border) !important;
        }

        tfoot tr {
            background-color: var(--footer-color);
            font-weight: bold;
        }

        tfoot td {
            border-top: 2px solid var(--table-border) !important;
        }

        .product-row td {
            border: 1px solid var(--table-border);
        }

        .total-row {
            font-weight: bold;
            background-color: var(--footer-color);
        }

        /* Estados y resaltados */
        .status-complete {
            color: #2ecc71;
            font-weight: bold;
        }

        .status-pending {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Resumen final */
        .final-summary {
            margin-top: 20px;
            border-top: 2px solid var(--table-border);
            padding-top: 15px;
        }

        .final-summary table {
            max-width: 300px;
            margin-left: auto;
            border: 1px solid var(--table-border);
        }

        .final-summary table td {
            border: 1px solid var(--table-border);
        }

        .final-summary thead tr {
            background-color: var(--header-color);
        }

        .heading td {
            background-color: var(--header-color);
            font-weight: bold;
            border-bottom: 2px solid var(--table-border);
        }

        .item td {
            border: 1px solid var(--table-border);
        }

        /* Responsive */
        @media print {
            .invoice-box {
                margin: 0;
                border: none;
                box-shadow: none;
            }

            .table-header,
            thead tr,
            tfoot tr {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <!-- Encabezado del movimiento -->
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('images/fish-222.png') }}"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Movimiento #: <strong>{{ $movimiento->codigo }}</strong><br />
                                Fecha Operación: {{ date('d/M/Y H:i', strtotime($movimiento->fecha)) }}<br />
                                Fecha Recibo: {{ $fechaActual->format('d/M/Y H:i:s') }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Información adicional según el tipo de movimiento -->
            @php
                $mostrarProveedor = $tipoMovimiento == 'ENTRADA';
                $mostrarAlmacen = $tipoMovimiento == 'ENTRADA';
                $mostrarCliente = $tipoMovimiento != 'ENTRADA';
                $mostrarRecinto = $tipoMovimiento != 'ENTRADA';

                $isFirstpage = true;
                $rowCounter = 0;
                $MaxRowperPage = 19;
            @endphp

            <!-- Información del operador y tipo de movimiento -->
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Operador: {{ $instanciaOperador->papellido }} {{ $instanciaOperador->carnet }}<br />
                                Tipo de movimiento: {{ $tipoMovimiento }}<br />
                                Recibo generado por: {{ $instanciaUsuario->papellido }} {{ $instanciaUsuario->carnet }}
                            </td>

                            <td>
                                @if ($mostrarCliente)
                                    Cliente: {{ $instanciaCliente }}<br />
                                @endif
                                @if ($mostrarRecinto)
                                    Recinto: {{ $instanciaRecinto }}<br />
                                @endif
                                @if ($mostrarProveedor)
                                    Proveedor: {{ $instanciaProveedor->papellido }}
                                    {{ $instanciaProveedor->carnet }}<br />
                                @endif
                                @if ($mostrarAlmacen)
                                    Almacén: {{ $instanciaAlmacen->nombre }}<br />
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @php
                $rowCounter = 3;
            @endphp
            <!-- Detalles del movimiento -->
            <tr>
                <td colspan="2">
                    <table>
                        <thead>
                            <tr class="heading">
                                <td>Producto</td>
                                <td>Precio</td>
                                <td>Cantidad</td>
                                <td>Subtotal</td>
                            </tr>
                        </thead>
                        @php
                            $rowCounter++;
                        @endphp
                        <tbody>
                            @foreach ($movimiento->detalles as $detalle)
                                <tr class="item">
                                    <td>{{ $detalle->producto->nombre }}<br />
                                        <strong>Código: </strong>{{ $detalle->producto->codigo }}
                                    </td>
                                    <td>{{ $detalle->precio }}</td>
                                    <td>x {{ $detalle->cantidad }}</td>
                                    <td>{{ $detalle->total }}</td>
                                </tr>
                                @php
                                    $rowCounter++;
                                @endphp
                                @if ($rowCounter > $MaxRowperPage && $isFirstpage)
                                    <tr class="page-break">
                                        <td colspan="4" class="text-muted">Continuación en la siguiente página...</td>
                                    </tr>;
                                    @php
                                        $rowCounter = 0;
                                        $isFirstpage = false;
                                    @endphp
                                @elseif ($rowCounter > $MaxRowperPage + 6 && !$isFirstpage)
                                    <tr class="page-break">
                                        <td colspan="4" class="text-muted">Continuación en la siguiente página...</td>
                                    </tr>;
                                    @php
                                        $rowCounter = 0;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total">
                                <td colspan="3" style="text-align: right;">Total Productos:</td>
                                <td>{{ $totalDet }}</td>
                            </tr>
                            @php
                                $rowCounter++;
                            @endphp
                            @if ($rowCounter > $MaxRowperPage && $isFirstpage)
                                <tr class="page-break">
                                    <td colspan="4" class="text-muted">Continuación en la siguiente página...</td>
                                </tr>;
                                @php
                                    $rowCounter = 0;
                                    $isFirstpage = false;
                                @endphp
                            @elseif ($rowCounter > $MaxRowperPage + 6 && !$isFirstpage)
                                <tr class="page-break">
                                    <td colspan="4" class="text-muted">Continuación en la siguiente página...</td>
                                </tr>;
                                @php
                                    $rowCounter = 0;
                                @endphp
                            @endif
                        </tfoot>
                    </table>
                </td>
            </tr>

            <!-- Cuotas si existen -->
            @if ($movimiento->cuotas->isNotEmpty())
                <td colspan="2">
                    <small>Existen cuotas en la continuación de este documento</small>
                </td>
                <tr>
                    <td colspan="2">
                        <table>
                            <thead>
                                <tr class="heading">
                                    <td>Código</td>
                                    <td>F. Venc.</td>
                                    <td>M. Asignado</td>
                                    <td>M. Cancelado</td>
                                    <td>M. Pendiente</td>
                                    <td>Estado</td>
                                </tr>
                            </thead>
                            @php
                                $rowCounter++;
                            @endphp
                            <tbody>
                                @php
                                    $total_mPgr = 0;
                                    $total_mPdo = 0;
                                    $total_mAde = 0;
                                    $estado = true;
                                @endphp
                                @foreach ($movimiento->cuotas as $cuota)
                                    <tr class="item">
                                        <td>{{ $cuota->codigo }}</td>
                                        <td>{{ date('d/M/Y', strtotime($cuota->fecha_venc)) }}</td>
                                        <td>{{ $cuota->monto_pagar }}</td>
                                        <td>{{ $cuota->monto_pagado }}</td>
                                        <td>{{ $cuota->monto_adeudado }}</td>
                                        <td>{{ $cuota->condicion }}</td>
                                        @php
                                            $total_mPgr += $cuota->monto_pagar;
                                            $total_mPdo += $cuota->monto_pagado;
                                            $total_mAde += $cuota->monto_adeudado;
                                            $estado = $estado && $cuota->condicion == 'PAGADA';
                                        @endphp
                                    </tr>
                                    @php
                                        $rowCounter++;
                                    @endphp
                                    @if ($rowCounter > $MaxRowperPage && $isFirstpage)
                                        <tr class="page-break">
                                            <td colspan="6" class="text-muted">Continuación en la siguiente página...</td>
                                        </tr>;
                                        @php
                                            $rowCounter = 0;
                                            $isFirstpage = false;
                                        @endphp
                                    @elseif ($rowCounter > $MaxRowperPage + 6 && !$isFirstpage)
                                        <tr class="page-break">
                                            <td colspan="6" class="text-muted">Continuación en la siguiente página...</td>
                                        </tr>;
                                        @php
                                            $rowCounter = 0;
                                        @endphp
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="0"><strong>T. Cuotas:</strong></td>
                                    <td>{{ number_format($total_mPgr, 2) }}</td>
                                    <td>{{ number_format($total_mPdo, 2) }}</td>
                                    <td>{{ number_format($total_mAde, 2) }}</td>
                                    <td>
                                        @if ($estado)
                                            <span style="color: limegreen"><strong>COMPLETO</strong></span>
                                        @else
                                            <span style="color: crimson"><strong>PENDIENTE</strong></span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $rowCounter++;
                                @endphp
                                @if ($rowCounter > $MaxRowperPage && $isFirstpage)
                                    <tr class="page-break">
                                        <td colspan="6" class="text-muted">Continuación en la siguiente página...</td>
                                    </tr>;
                                    @php
                                        $rowCounter = 0;
                                        $isFirstpage = false;
                                    @endphp
                                @elseif ($rowCounter > $MaxRowperPage + 6 && !$isFirstpage)
                                    <tr class="page-break">
                                        <td colspan="6" class="text-muted">Continuación en la siguiente página...</td>
                                    </tr>;
                                    @php
                                        $rowCounter = 0;
                                    @endphp
                                @endif
                            </tfoot>
                        </table>
                    </td>
                </tr>
                @if ($movimiento->cuotas->isNotEmpty() && $movimiento->cuotas->isNotEmpty())
                    @if($rowCounter > $MaxRowperPage)
                        <tr class="page-break">
                            <td colspan="2" class="text-muted">Continuación en la siguiente"—>
                        </tr>;
                        @php
                            $rowCounter = 0;
                        @endphp
                    @endif
                    <tr>
                        <td colspan="2">
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr class="heading">
                                        <td>Concepto</td>
                                        <td>Monto</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item">
                                        <td>Total Productos</td>
                                        <td> {{ number_format($totalDet, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr class="item">
                                        @if ($total_mPgr > $totalDet)
                                            <td>Aditivo</td>
                                            <td>+{{ number_format($total_mPgr - $totalDet, 2) }}</td>
                                        @else
                                            <td>Descuento</td>
                                            <td>-{{ number_format($totalDet - $total_mPgr, 2) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr class="item">
                                        <td>Total Cuotas</td>
                                        <td>
                                            <h3>{{ number_format($total_mPgr, 2) }}</h3>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endif
            @else
                <table>
                    <tr class="item">
                        <td colspan="2">
                            <h3>
                                No se asignaron cuotas/PAGOS para este movimiento.
                            </h3>
                        </td>
                    </tr>
                </table>
                </td>
            @endif
        </table>
    </div>
</body>

</html>
