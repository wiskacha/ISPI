<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 landscape
        }
    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 0;
            padding: 0; */
            font-size: 12px;
            /* Adjusted font size for better print legibility */
        }

        @page {
            size: A4 landscape;
            margin: 15mm;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            /* Adjusted margin */
        }

        th,
        td {
            padding: 8px;
            /* Increased padding for better spacing */
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
            /* Consistent font size for table cells */
        }

        th {
            background-color: #f2f2f2;
            /* Light gray for headers */
            font-weight: bold;
            /* Bold for header for clarity */
        }

        .thead-light th {
            background-color: #f8f9fa;
            /* Light background for tables */
        }

        .clickable-row {
            cursor: pointer;
        }

        .page-break {
            page-break-after: always;
        }


        .table-responsive {
            overflow-x: auto;
            /* Allow horizontal scrolling for small screens */
        }

        @media print {
            .table-responsive {
                overflow: visible;
                /* Ensure all content is visible when printed */
            }

            th,
            td {
                font-size: 12px;
                /* Ensure consistent font size in print */
            }

            .continue-message {
                font-weight: bold;
                margin-bottom: 10px;
            }


            .page-break {
                page-break-after: always;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            h2 {
                page-break-before: always;
            }
        }

        hr {
            border: 1px solid #ddd;
            /* Subtle line for separation */
            margin: 10px 0;
            /* Spacing around the line */
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
@php
    // Inicializamos el contador de páginas
    $pageBreakCount = 0;

    // Función para contar los saltos de página
    function countPageBreaks($movimientos)
    {
        $count = 0;
        foreach ($movimientos as $movimiento) {
            // Contamos el salto de página para cada movimiento (excepto el primero)
            if ($count > 0) {
                $count++;
            }

            // Contamos los saltos de página en los detalles
            $detallesCount = $movimiento->detalles->count();
            if ($detallesCount > 9) {
                $count += ceil(($detallesCount - 9) / 12);
            }

            // Contamos los saltos de página en las cuotas
            if ($movimiento->cuotas->count() > 0) {
                $cuotasCount = $movimiento->cuotas->count();
                if ($cuotasCount > 9) {
                    $count += ceil(($cuotasCount - 9) / 12);
                }
                // Añadimos una página extra para la tabla de totales
                $count++;
            }
        }
        return $count;
    }

    // Contamos los saltos de página
    $pageBreakCount = countPageBreaks($movimientos);

    // Calculamos el total de páginas (saltos de página + 1 para la primera página)
    $totalPages = $pageBreakCount + 1;
@endphp

<body class="A4 landscape">
    <div class="container-fluid"
        style="position: fixed; top: 0; left: 0; right: 0; background-color: #f2f2f2; padding: 10px; height: 50px;">
        <table style="margin-top: -2px;">
            <thead>
                <th> <img src="{{ public_path('images/fish-222.png') }}" class="img-fluid" alt="Company Logo"
                        style="max-width: 300px;"></th>
                <th style="text-align: center">Tipo : Desglose de Movimientos</th>
                <th style="text-align: center">Reporte Generado por : {{ Auth::user()->persona->carnet }}</th>:
                <th style="text-align: center">Fecha : {{ now()->format('d/m/Y H:i') }}</th>
                <th style="text-align: center">Página <span class="page-number"></span> de {{ $totalPages }}</th>
            </thead>
        </table>
    </div>

    <div style="position: fixed; bottom: 0; left: 0; right: 0; height: 50px; background-color: #f2f2f2; padding: 10px;">
        <table style="margin-top: -7px;">
            <thead>
                <th rowspan="2">Criterios:</th>
                <th style="text-align: center">Tipo:</th>
                <th style="text-align: center">Almacen:</th>
                <th style="text-align: center">Op:</th>
                <th style="text-align: center">Cr:</th>
                <th style="text-align: center">Cliente:</th>
                <th style="text-align: center">Recinto:</th>
                <th style="text-align: center">Proveedor:</th>
                <th colspan="2" style="text-align: center">Fechas</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if (isset($criteriosB['tipo']))
                            {{ $criteriosB['tipo'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['almacen']))
                            {{ $criteriosB['almacen'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['operador']))
                            {{ $criteriosB['operador'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['producto']))
                            {{ $criteriosB['producto'] }}
                        @elseif(isset($criteriosB['empresa']))
                            {{ $criteriosB['empresa'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['cliente']))
                            {{ $criteriosB['cliente'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['recinto']))
                            {{ $criteriosB['recinto'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['proveedor']))
                            {{ $criteriosB['proveedor'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['desde']))
                            {{ $criteriosB['desde'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['hasta']))
                            {{ $criteriosB['hasta'] }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    @php
        $isFirstPage = true;
    @endphp
    <div style="position: absolute; top: 80px; bottom: 80px; left: 0; right: 0; background-color: rgb(241, 241, 241);">
        <div id="contenido-tabla" class="block-content block-content-full collapse">
            @if ($movimientos->isEmpty())
                <div class="alert alert-info">
                    No se encontraron movimientos que coincidan con los criterios de búsqueda.
                </div>
            @else
                @php $check = false; @endphp
                @foreach ($movimientos as $movimiento)
                    @if (!$isFirstPage)
                        <div class="page-break"></div>
                    @else
                        @php $isFirstPage = false; @endphp
                    @endif
                    <div class="contenido">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 10%;">Código</th>
                                    <th style="width: 10%;">Tipo</th>
                                    <th style="width: 15%;">Almacén</th>
                                    <th style="width: 15%;">Operador</th>
                                    <th style="width: 10%;">Cliente</th>
                                    <th style="width: 15%;">Recinto</th>
                                    <th style="width: 15%;">Proveedor</th>
                                    <th style="width: 10%;">Fecha</th>
                                    <th style="width: 10%;">Total Productos</th>
                                    <th style="width: 10%;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $movimiento->codigo }}</td>
                                    <td>{{ $movimiento->tipo }}</td>
                                    <td>{{ $movimiento->almacene->nombre ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->usuario->persona->carnet ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->cliente->carnet ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->recinto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->persona->carnet ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $movimiento->detalles->count() }}</td>
                                    @if ($movimiento->tipo == 'ENTRADA')
                                        <td>No Aplica</td>
                                    @else
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
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 20%;">Empresa</th>
                                    <th style="width: 30%;">Producto</th>
                                    <th style="width: 15%;">Cantidad</th>
                                    <th style="width: 15%;">Precio Unitario</th>
                                    <th style="width: 15%;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalP = 0;
                                    $cant_filas = 0;
                                @endphp
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
                                    @php $cant_filas++; @endphp
                                    @if ($cant_filas == 9 && $check == false)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">Continua en la siguiente hoja!</td>
                                        </tr>
                                        <tr class="page-break"></tr>
                                        <tr>
                                            <td colspan="6">Continuación de los detalles del movimiento:
                                                {{ $movimiento->codigo }}</td>
                                        </tr>
                                        @php $cant_filas = 0; @endphp
                                        @php $check = true; @endphp
                                    @elseif ($cant_filas == 12 && $loop->last == true)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">Continua en la siguiente hoja!</td>
                                        </tr>
                                        <tr class="page-break"></tr>
                                        <tr>
                                            <td colspan="6">Continuación de los detalles del movimiento:
                                                {{ $movimiento->codigo }}</td>
                                        </tr>
                                        @php $check = true; @endphp
                                    @endif
                                @endforeach
                                @php $check = false; @endphp
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>TOTAL:</td>
                                    <td>{{ number_format($totalP, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @if ($movimiento->cuotas->count() > 0)
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 30%;">Concepto</th>
                                        <th style="width: 20%;">Código</th>
                                        <th style="width: 15%;">Fecha V.</th>
                                        <th style="width: 15%;">M. Pagar</th>
                                        <th style="width: 15%;">M. Pagado</th>
                                        <th style="width: 15%;">M. Pendiente</th>
                                        <th style="width: 15%;">Condición</th>
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
                                            <td>{{ $cuota->monto_pagar }}</td>
                                            <td>{{ $cuota->monto_pagado }}</td>
                                            <td>{{ $cuota->monto_adeudado }}</td>
                                            <td>{{ $cuota->condicion }}</td>
                                            @php
                                                $total_mPgr += $cuota->monto_pagar;
                                                $total_mPdo += $cuota->monto_pagado;
                                                $total_mAde += $cuota->monto_adeudado;
                                                if ($cuota->condicion == 'PENDIENTE') {
                                                    $estado = false;
                                                }
                                            @endphp
                                        </tr>
                                        @php $cant_filas++; @endphp
                                        @if ($cant_filas == 9 && $check == false)
                                            <tr class="page-break">
                                                <td colspan="7">Continua en la siguiente hoja!</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Continuación de la cuotas del movimiento:
                                                    {{ $movimiento->codigo }}</td>
                                            </tr>
                                            @php $cant_filas = 0; @endphp
                                            @php $check = true; @endphp
                                        @elseif ($cant_filas == 12 && $check == true)
                                            <tr class="page-break">
                                                <td colspan="7">Continua en la siguiente hoja!</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Continuación de las cuotas del movimiento:
                                                    {{ $movimiento->codigo }}</td>
                                                <td></td>
                                            </tr>
                                            @php $cant_filas = 0; @endphp
                                            @php $check = true; @endphp
                                        @endif
                                    @endforeach
                                    @php $check = false; @endphp
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <strong>
                                                TOTAL:
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ number_format($total_mPgr, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ number_format($total_mPdo, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                {{ number_format($total_mAde, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if ($estado)
                                                <span style="color: limegreen"><strong>COMPLETO</strong></span>
                                            @else
                                                <span style="color: crimson"><strong>PENDIENTE</strong></span>
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="page-break"></div>
                            <table
                                class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 15px;">
                                        <strong>
                                            Totales detallados del movimiento {{ $movimiento->codigo }}
                                        </strong>
                                    </td>
                                </tr>
                                <thead>
                                    <tr>
                                        <th style="text-align: right;">Concepto</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: right;">Total Productos</td>
                                        <td>
                                            <strong>
                                                {{ number_format($totalP, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        @if ($total_mPgr > $totalP)
                                            <td style="text-align: right;">Aditivo</td>
                                            <td>
                                                <strong>
                                                    +{{ number_format($total_mPgr - $totalP, 2) }}
                                                </strong>
                                            </td>
                                        @else
                                            <td style="text-align: right;">Descuento</td>
                                            <td>
                                                <strong>
                                                    -{{ number_format($totalP - $total_mPgr, 2) }}
                                                </strong>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">Total Cuotas</td>
                                        <td>
                                            <strong>
                                                {{ number_format($total_mPgr, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                @endforeach
        </div>
        @endif
    </div>
    </div>
</body>

</html>
