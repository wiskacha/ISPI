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

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
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
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Movimiento #: {{ $movimiento->codigo }}<br />
                                Fecha: {{ $fechaActual }}<br />
                            </td>
                        </tr>
                    </table>
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

            <!-- Detalles del movimiento -->
            <tr class="heading">
                <td>Producto</td>
                <td>Subtotal</td>
            </tr>

            @foreach ($movimiento->detalles as $detalle)
                <tr class="item">
                    <td>
                        Producto: {{ $detalle->producto->nombre }}<br />
                        Código: {{ $detalle->producto->codigo }}<br />
                        Cantidad: {{ $detalle->cantidad }}<br />
                        Precio: {{ $detalle->precio }}
                    </td>
                    <td>
                        {{ $detalle->total }}
                    </td>
                </tr>
            @endforeach

            <!-- Total del movimiento -->
            <tr class="total">
                <td></td>
                <td>Total: {{ $totalDet }}</td>
            </tr>

            <!-- Cuotas si existen -->
            @if ($movimiento->cuotas->isNotEmpty())
                <tr class="heading">
                    <td>Cuota</td>
                    <td>Estado</td>
                </tr>

                @foreach ($movimiento->cuotas as $cuota)
                    <tr class="item">
                        <td>
                            Cuota: {{ $cuota->numero }}<br />
                            Código: {{ $cuota->codigo }}<br />
                            Concepto: {{ $cuota->concepto }}<br />
                            Fecha de vencimiento: {{ $cuota->fecha_venc }}<br />
                            Monto Asignado: {{ $cuota->monto_pagar }}<br />
                            Monto Cancelado: {{ $cuota->monto_pagado }}<br />
                            Monto Pendiente: {{ $cuota->monto_adeudado }}
                        </td>
                        <td>{{ $cuota->condicion }}</td>
                    </tr>
                @endforeach
            @else
                <tr class="item">
                    <td colspan="2">
                        <h3>
                            No se asignaron cuotas/PAGOS para este movimiento.
                        </h3>
                    </td>
                </tr>
            @endif
        </table>
    </div>
</body>

</html>
