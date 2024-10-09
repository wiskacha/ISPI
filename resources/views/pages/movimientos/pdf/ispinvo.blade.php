<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Movimiento de Inventario</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;

        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <!-- Encabezado del movimiento -->
            <tr class="top">
                @if (!$movimiento->cuotas->isNotEmpty())
                    <td colspan="2">
                @endif
                <td>
                    <tr>
                        <td class="title">
                            <img src="{{ public_path('images/fish-222.png') }}" style="width: 100%; max-width: 300px" />
                        </td>

                        <td>
                            Movimiento #: <strong>{{ $movimiento->codigo }}</strong><br />
                            Fecha Operación: {{ date('d/M/Y H:i', strtotime($movimiento->fecha))}} <br />
                            Fecha Recibo: {{ date('d/M/Y H:i', strtotime($fechaActual)) }}<br />
                        </td>
                    </tr>
                </td>
            </tr>
            <!-- Información adicional según el tipo de movimiento -->
            @php
                if ($tipoMovimiento == 'ENTRADA') {
                    $mostrarProveedor = true;
                    $mostrarAlmacen = true;
                    $mostrarCliente = false;
                    $mostrarRecinto = false;
                } else {
                    $mostrarProveedor = false;
                    $mostrarAlmacen = false;
                    $mostrarCliente = true;
                    $mostrarRecinto = true;
                }
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
                                    Cliente: {{ $instanciaCliente->papellido }} {{ $instanciaCliente->carnet }}<br />
                                @endif
                                @if ($mostrarRecinto)
                                    Recinto: {{ $instanciaRecinto->nombre }}<br />
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

            <td colspan="2">
                <table cellpadding="0" cellspacing="0">
                    <thead>
                        <!-- Detalles del movimiento -->
                        <tr class="heading">
                            <td>Producto</td>
                            <td>Precio</td>
                            <td>Cantidad</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimiento->detalles as $detalle)
                            <tr class="item">
                                <td>
                                    {{ $detalle->producto->nombre }}<br />
                                    <strong>Código: </strong>{{ $detalle->producto->codigo }}
                                </td>
                                <td>
                                    {{ $detalle->precio }}
                                </td>
                                <td>
                                    x {{ $detalle->cantidad }}
                                </td>
                                <td>
                                    {{ $detalle->total }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <!-- Total del movimiento -->
                        <tr class="total">
                            <td></td>
                            <td colspan="4">Total Productos: | {{ $totalDet }}</td>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                </br>
                <!-- Cuotas si existen -->
                @if ($movimiento->cuotas->isNotEmpty())
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="heading">
                                <td>Concepto</td>
                                <td>Código</td>
                                <td>F.Venc</td>
                                <td>M. Asignado</td>
                                <td>M. Cancelado</td>
                                <td>M. Pendiente</td>
                                <td>Estado</td>
                            </tr>
                        </thead>
                        @php
                            $total_mPgr = 0;
                            $total_mPdo = 0;
                            $total_mAde = 0;
                            $estado = true;
                        @endphp
                        @foreach ($movimiento->cuotas as $cuota)
                            <tr class="item">
                                <td>{{ $cuota->concepto }}</td>
                                <td>{{ $cuota->codigo }}</td>
                                <td>{{ date('d/M/Y', strtotime($cuota->fecha_venc)) }}</td>
                                <td>{{ $cuota->monto_pagar }}
                                    @php
                                        $total_mPgr += $cuota->monto_pagar;
                                    @endphp
                                </td>
                                <td>{{ $cuota->monto_pagado }}
                                    @php
                                        $total_mPdo += $cuota->monto_pagado;
                                    @endphp
                                </td>
                                <td>{{ $cuota->monto_adeudado }}
                                    @php
                                        $total_mAde += $cuota->monto_adeudado;
                                    @endphp
                                </td>
                                <td>{{ $cuota->condicion }}
                                    @php
                                        if ($cuota->condicion == 'PAGADA') {
                                            $estado *= true;
                                        } else {
                                            $estado *= false;
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                        <hr>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td style="text-align: right" colspan="2"><strong>Total Cuotas: |</strong></td>
                                <!-- Display the respective totals -->
                                <td colspan="1"><strong>{{ number_format($total_mPgr, 2) }}</strong></td>
                                <td colspan="1"><strong>{{ number_format($total_mPdo, 2) }}</strong></td>
                                <td colspan="1"><strong>{{ number_format($total_mAde, 2) }}</strong></td>
                                <td colspan="1" style="text-align: center">
                                    @if ($estado)
                                        <span style="color: chartreuse"><strong>COMPLETO</strong></span>
                                    @else
                                        <span style="color: crimson"><strong>PENDIENTE</strong></span>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    @if ($movimiento->cuotas->isNotEmpty() && $movimiento->cuotas->isNotEmpty())
                        <div class="page-break"></div>
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
                                <hr>
                                <tr class="item">
                                    @if ($total_mPgr > $totalDet)
                                        <td>Aditivo</td>
                                        <td>+{{ number_format($total_mPgr - $totalDet, 2) }}</td>
                                    @else
                                        <td>Descuento</td>
                                        <td>-{{ number_format($totalDet - $total_mPgr, 2) }}</td>
                                    @endif
                                </tr>
                                <hr>
                                <tr class="item">
                                    <td>Total Cuotas</td>
                                    <td>
                                        <h3>{{ number_format($total_mPgr, 2) }}</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
