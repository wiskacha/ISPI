@extends('pages.reportes.pdf.membrete')

@section('content')


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
                margin: 0;
                padding: 0;
                font-size: 12px;
                /* Adjusted font size for better print legibility */
            }

            @page {
                size: A4 landscape;
                /* A4 landscape */
                margin: 15mm;
                /* Increased margin for better aesthetics */
            }

            table {
                width: 100%;
                page-break-inside: auto;
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
        </style>
    </head>

    <body class="A4 landscape">
        <script>
            window.onload = function() {
                const tables = document.querySelectorAll('.table');
                tables.forEach(table => {
                    const tableHeight = table.offsetHeight; // Get height of the table
                    const pageHeight = 297 - 30; // A4 height in mm (210 mm width minus margins)

                    if (tableHeight > pageHeight) {
                        // Logic to handle breaking the main table over pages
                        const continueMessage = document.createElement('div');
                        continueMessage.classList.add('continue-message');
                        continueMessage.textContent = 'Continuará en la siguiente página...';
                        table.parentNode.insertBefore(continueMessage, table.nextSibling);
                    }

                    // Handle sub-tables (detalles and cuotas)
                    const subTables = table.parentNode.querySelectorAll('.table-bordered');
                    subTables.forEach(subTable => {
                        const subTableHeight = subTable.offsetHeight;

                        if (subTableHeight > pageHeight) {
                            let currentRow = 0;
                            const rows = subTable.tBodies[0].rows;
                            const numRows = rows.length;
                            const maxRows = Math.floor(pageHeight / 20); // Assuming a row height of 20px

                            while (currentRow < numRows) {
                                const continueMessage = document.createElement('div');
                                continueMessage.classList.add('continue-message');
                                continueMessage.textContent = 'Continuará en la siguiente página...';
                                subTable.parentNode.insertBefore(continueMessage, subTable.nextSibling);

                                const tempTable = document.createElement('table');
                                tempTable.classList.add('table', 'table-bordered');

                                const thead = subTable.tHead.cloneNode(true);
                                tempTable.appendChild(thead);

                                const tbody = document.createElement('tbody');
                                tempTable.appendChild(tbody);

                                for (let i = 0; i < maxRows && currentRow < numRows; i++, currentRow++) {
                                    const row = rows[currentRow].cloneNode(true);
                                    tbody.appendChild(row);
                                }

                                subTable.parentNode.insertBefore(tempTable, subTable.nextSibling);
                            }
                        }
                    });
                });
            };
        </script>
        <div id="contenido-tabla" class="block-content block-content-full collapse">
            @if ($movimientos->isEmpty())
                <div class="alert alert-info">
                    No se encontraron movimientos que coincidan con los criterios de búsqueda.
                </div>
            @else
                <div class="table-responsive">
                    @foreach ($movimientos as $movimiento)
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                            <thead>
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
                                    <th style="width: 10%;">Total</th>
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
                                </tr>
                            </tbody>
                        </table>

                        <div class="table-responsive">
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
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>TOTAL:</td>
                                        <td>{{ number_format($totalP, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if ($movimiento->cuotas->count() > 0)
                            <div class="table-responsive">
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
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>TOTAL:</td>
                                            <td>{{ number_format($total_mPgr, 2) }}
                                            </td>
                                            <td>{{ number_format($total_mPdo, 2) }}
                                            </td>
                                            <td>{{ number_format($total_mAde, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                        <div class="page-break"></div>
                    @endforeach
                </div>
            @endif
        </div>
    </body>

    </html>
    <!-- Todo el contenido actual de desglose.blade.php -->
@endsection
