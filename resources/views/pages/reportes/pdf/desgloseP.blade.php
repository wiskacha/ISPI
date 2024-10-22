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
    // Función autónoma para contar los saltos de página, considerando solo productos únicos
    function countUniqueProductPageBreaks($uniqueProducts)
    {
        $pageCount = 0; // Contador de páginas

        // Contamos las páginas necesarias para los productos únicos
        $uniqueProductCount = $uniqueProducts->count();

        // Se asume que la primera página contiene hasta 9 productos
        if ($uniqueProductCount > 9) {
            // Calculamos las páginas adicionales necesarias
            $pageCount += ceil(($uniqueProductCount - 9) / 12);
        }

        // Añadimos la primera página que siempre existirá
        $pageCount++; 

        // Añadimos una página adicional para el resumen final del reporte
        // $pageCount++;

        return $pageCount;
    }

    // Agrupamos los productos únicos a través de todos los movimientos
    $uniqueProductsForPageCount = $movimientos->flatMap->detalles->unique(function ($detalle) {
        return $detalle->producto->codigo; // Agrupamos por el código del producto para asegurarnos de que sean únicos
    });

    // Contamos los saltos de página para los productos únicos
    $uniqueProductPageBreakCount = countUniqueProductPageBreaks($uniqueProductsForPageCount);

    // Calculamos el total de páginas, incluyendo la primera página
    $totalPages = $uniqueProductPageBreakCount;
@endphp




<body class="A4 landscape">
    <div class="container-fluid"
        style="position: fixed; top: 0; left: 0; right: 0; background-color: #f2f2f2; padding: 10px; height: 50px;">
        <table style="margin-top: -2px;">
            <thead>
                <th> <img src="{{ public_path('images/fish-222.png') }}" class="img-fluid" alt="Company Logo"
                        style="max-width: 300px;"></th>
                <th style="text-align: center">Tipo : Desglose Por Producto</th>
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
                <th colspan="2" style="text-align: center">
                    Mov.
                    @if (isset($criteriosB['criterio_fecha']))
                        {{ $criteriosB['criterio_fecha'] }}
                    @else
                        <small>No especificado</small>
                    @endif
                </th>
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
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $criteriosB['desde'])->format('d/m/Y') }}
                        @else
                            <small>No especificado</small>
                        @endif
                    </td>
                    <td>
                        @if (isset($criteriosB['hasta']))
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $criteriosB['hasta'])->format('d/m/Y') }}
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
                <div class="contenido">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 30%;">Producto</th>
                                <th style="width: 10%">Precio Act</th>
                                <th style="width: 10%;">Precio Min</th>
                                <th style="width: 10%;">Precio Max</th>
                                <th style="width: 10%;">Precio Avg</th>
                                @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] === 'Existencias')
                                    <th style="width: 10%;">Cant. E</th>
                                    <th style="width: 10%;">Cant. S</th>
                                    <th style="width: 10%;">Cant. T</th>
                                    <th style="width: 10%;">SubT. E</th>
                                    <th style="width: 10%;">SubT. S</th>
                                    <th style="width: 10%;">SubT. T</th>
                                @else
                                    <th style="width: 10%;">Cantidad</th>
                                    <th style="width: 10%;">Subtotal</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Collect and group unique products by their empresa
                                $productosAgrupadosPorEmpresa = $movimientos->flatMap->detalles->groupBy(function (
                                    $detalle,
                                ) {
                                    return $detalle->producto->empresa->nombre ?? 'Sin Empresa';
                                });
                                $subtotalGeneral = 0;
                                $subtotalEGeneral = 0; // Total for SubT. E
                                $subtotalSGeneral = 0; // Total for SubT. S
                                $subtotalTGeneral = 0; // Total for SubT. T
                                $cant_mov = 0;
                                $contador_rows = 0;
                                $rows_perpage = 10;
                            @endphp

                            {{-- Iterate through each empresa and its associated products --}}
                            @foreach ($productosAgrupadosPorEmpresa as $empresaNombre => $detallesEmpresa)
                                @if ($contador_rows >= $rows_perpage)
                                    <tr class="page-break">
                                        @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] == 'Existencias')
                                            <td colspan="11"></td>
                                        @else
                                            <td colspan="7"></td>
                                        @endif
                                    </tr>
                                    @php $contador_rows = 0; @endphp
                                @endif
                                {{-- Empresa Name Row --}}
                                <tr style="background-color: #f5f5f5;">
                                    @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] == 'Existencias')
                                        <td colspan="11"><strong>{{ $empresaNombre }}</strong></td>
                                    @else
                                        <td colspan="7"><strong>{{ $empresaNombre }}</strong></td>
                                    @endif
                                </tr>

                                @php
                                    $contador_rows++;
                                    // Group products by unique id_producto within the empresa
                                    $productosUnicos = $detallesEmpresa->pluck('producto')->unique('id_producto');
                                @endphp

                                @foreach ($productosUnicos->sortBy('nombre') as $productoP)
                                    @php
                                        // Get all details for the current product within this empresa
                                        $detallesProducto = $detallesEmpresa->filter(function ($detalle) use (
                                            $productoP,
                                        ) {
                                            return $detalle->producto->id_producto === $productoP->id_producto;
                                        });

                                        // Initialize quantities and subtotals
                                        $cantidadE = $detallesProducto
                                            ->where('movimiento.tipo', 'ENTRADA')
                                            ->sum('cantidad');
                                        $cantidadS = $detallesProducto
                                            ->where('movimiento.tipo', 'SALIDA')
                                            ->sum('cantidad');
                                        $subtotalE = $detallesProducto
                                            ->where('movimiento.tipo', 'ENTRADA')
                                            ->sum('total');
                                        $subtotalS = $detallesProducto
                                            ->where('movimiento.tipo', 'SALIDA')
                                            ->sum('total');

                                        // Nuevas variables para contar el número de detalles
                                        $cantidadE = $detallesProducto->where('movimiento.tipo', 'ENTRADA')->count(); // Contar detalles con tipo 'ENTRADA'

                                        $cantidadS = $detallesProducto->where('movimiento.tipo', 'SALIDA')->count(); // Contar detalles con tipo 'SALIDA'

                                        // Calcular la cantidad total (opcional)
                                        $cant_mov = $cantidadE + $cantidadS; // Total de conteo

                                        // Calculate totals for the existence case
                                        $cantidadT = $cantidadE - $cantidadS;
                                        $subtotalT = $subtotalE - $subtotalS;
                                        $subtotalGeneral += $subtotalT; // Sum the total for the general subtotal
                                        $subtotalEGeneral += $subtotalE; // Sum for SubT. E
                                        $subtotalSGeneral += $subtotalS; // Sum for SubT. S
                                        $subtotalTGeneral += $subtotalT; // Sum for SubT. T

                                    @endphp
                                    @if ($contador_rows >= $rows_perpage)
                                        <tr class="page-break">
                                            @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] == 'Existencias')
                                                <td colspan="11"></td>
                                            @else
                                                <td colspan="7"></td>
                                            @endif
                                        </tr>
                                        @php $contador_rows = 0; @endphp
                                    @endif
                                    {{-- Product Row --}}
                                    <tr>
                                        <td>
                                            [{{ $productoP->codigo }}]
                                            <small>{{ $productoP->nombre }}</small>
                                        </td>
                                        <td>{{ $productoP->precio }}</td> {{-- Current product price --}}
                                        <td>{{ $detallesProducto->min('precio') }}</td> {{-- Minimum price in the details --}}
                                        <td>{{ $detallesProducto->max('precio') }}</td> {{-- Maximum price in the details --}}
                                        <td>{{ number_format($detallesProducto->avg('precio'), 2) }}</td>

                                        @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] === 'Existencias')
                                            <td>{{ $cantidadE }}</td> {{-- Cant. E --}}
                                            <td>{{ $cantidadS }}</td> {{-- Cant. S --}}
                                            <td>{{ $cantidadT }}</td> {{-- Cant. T --}}
                                            <td>{{ $subtotalE }}</td> {{-- SubT. E --}}
                                            <td>{{ $subtotalS }}</td> {{-- SubT. S --}}
                                            <td>{{ $subtotalT }}</td> {{-- SubT. T --}}
                                        @else
                                            <td>{{ $detallesProducto->sum('cantidad') }}</td> {{-- Quantity --}}
                                            <td>{{ $detallesProducto->sum('total') }}</td> {{-- Subtotal --}}
                                        @endif
                                    </tr>
                                    @php $contador_rows++; @endphp
                                @endforeach
                                @if ($contador_rows >= $rows_perpage)
                                    <tr class="page-break">
                                        @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] == 'Existencias')
                                            <td colspan="11"></td>
                                        @else
                                            <td colspan="7"></td>
                                        @endif
                                    </tr>
                                    @php $contador_rows = 0; @endphp
                                @endif
                                {{-- Blank Row for separation between empresas --}}
                                <tr>
                                    @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] == 'Existencias')
                                        <td colspan="11">&nbsp;</td>
                                    @else
                                        <td colspan="7">&nbsp;</td>
                                    @endif
                                </tr>
                                @php $contador_rows++; @endphp
                            @endforeach
                        </tbody>

                        <tfoot>
                            @if ($contador_rows >= $rows_perpage)
                                <tr class="page-break">
                                    <td></td>
                                </tr>
                                @php $contador_rows = 0; @endphp
                            @endif
                            <tr>
                                @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] !== 'Existencias')
                                    <td colspan="5"></td>
                                @else
                                    <td colspan="7"></td>
                                @endif
                                <td><strong>TOTAL:</strong></td>
                                @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] === 'Existencias')
                                    <td>{{ $subtotalEGeneral }}</td> {{-- Total SubT. E --}}
                                    <td>{{ $subtotalSGeneral }}</td> {{-- Total SubT. S --}}
                                    <td>{{ $subtotalTGeneral }}</td> {{-- Total SubT. T --}}
                                @else
                                    <td colspan="1">{{ abs($subtotalGeneral) }}</td> {{-- Total for Quantity and Subtotal --}}
                                @endif
                            </tr>
                            <tr>
                                @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] !== 'Existencias')
                                    <td colspan="7">
                                    @else
                                    <td colspan="13">
                                @endif
                                </td>
                            </tr>
                            <tr>
                                @if (isset($criteriosB['tipo']) && $criteriosB['tipo'] !== 'Existencias')
                                    <td colspan="7">
                                    @else
                                    <td colspan="13">
                                @endif
                                Este reporte analizó un total de:
                                @php $queryCount=0; @endphp
                                @foreach ($movimientos as $mv)
                                    @php $queryCount++; @endphp
                                @endforeach
                                <strong>
                                    {{ $queryCount }}
                                </strong>
                                movimientos / transacciones.
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
