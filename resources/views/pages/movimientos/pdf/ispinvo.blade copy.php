<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>A simple, clean, and responsive HTML invoice template</title>

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

        .invoice-box table tr.details td {
            padding-bottom: 20px;
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

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Invoice #: 123<br />
                                Created: January 1, 2023<br />
                                Due: February 1, 2023
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>

                        <tr>
                            <td>
                                Sparksuite, Inc.<br />
                                12345 Sunny Road<br />
                                Sunnyville, CA 12345
                            </td>

                            <td>
                                Acme Corp.<br />
                                John Doe<br />
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>

                <td>Check #</td>
            </tr>

            <tr class="details">
                <td>Check</td>

                <td>1000</td>
            </tr>

            <tr class="heading">
                <td>Item</td>

                <td>Price</td>
            </tr>

            <tr class="item">
                <td>Website design</td>

                <td>$300.00</td>
            </tr>

            <tr class="item">
                <td>Hosting (3 months)</td>

                <td>$75.00</td>
            </tr>

            <tr class="item last">
                <td>Domain name (1 year)</td>

                <td>$10.00</td>
            </tr>

            <tr class="total">
                <td></td>

                <td>Total: $385.00</td>
            </tr>
        </table>
    </div>

    {{-- EJEMPLO DE DATOS:  --}}
    <div>
        {{-- 'movimiento', 'totalDet', 'fechaActual', 'instanciaOperador', 'instanciaProveedor', 'instanciaAlmacen', 'tipoMovimiento', 'instanciaUsuario' --}}
        <p>Total: {{ $totalDet }}</p>
        <p>Fecha: {{ $fechaActual }}</p>
        <p>Operador: {{ $instanciaOperador->papellido }} {{ $instanciaOperador->carnet }}</p>
        <p>Tipo de movimiento: {{ $tipoMovimiento }}</p>
        <p>Recibo generado por: {{ $instanciaUsuario->papellido }} {{ $instanciaUsuario->carnet }}</p>

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

        @if ($mostrarProveedor)
            <p>Proveedor: {{ $instanciaProveedor->papellido }} {{ $instanciaProveedor->carnet }}</p>
        @endif

        @if ($mostrarAlmacen)
            <p>Almacen: {{ $instanciaAlmacen->nombre }}</p>
        @endif

        @if ($mostrarCliente)
            <p>Cliente: {{ $instanciaCliente->papellido }} {{ $instanciaCliente->carnet }}</p>
        @endif

        @if ($mostrarRecinto)
            <p>Recinto: {{ $instanciaRecinto->nombre }}</p>
        @endif

        @foreach ($movimiento->detalles as $detalle)
            <p>Producto: {{ $detalle->producto->nombre }}</p>
            <p>Código: {{ $detalle->producto->codigo }}</p>
            <p>Cantidad: {{ $detalle->cantidad }}</p>
            <p>Precio: {{ $detalle->precio }}</p>
            <p>Subtotal: {{ $detalle->total }}</p>
            <br />
        @endforeach

        @foreach ($movimiento->cuotas as $cuota)
            <p>Cuota: {{ $cuota->numero }}</p>
            <p>Código: {{ $cuota->codigo }}</p>
            <p>Concepto: {{ $cuota->concepto }}</p>
            <p>Fecha de vencimiento: {{ $cuota->fecha_venc }}</p>
            <p>Monto Asignado: {{ $cuota->monto_pagar }}</p>
            <p>Monto Cancelado: {{ $cuota->monto_pagado }}</p>
            <p>Monto Pendiente: {{ $cuota->monto_pendiente }}</p>
            <p>Estado: {{ $cuota->condicion }}</p>
            <br />
        @endforeach

    </div>
</body>

</html>
