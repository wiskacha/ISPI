@extends('layouts.backend')

@section('content')
    <div class="container">
        <h1 class="mb-4">Reporte de Movimientos</h1>

        <!-- Check if there are any movimientos to display -->
        @if ($movimientos->isEmpty())
            <div class="alert alert-info">
                No se encontraron movimientos que coincidan con los criterios de búsqueda.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->codigo }}</td>
                                <td>{{ $movimiento->tipo }}</td> <!-- ENTRADA or SALIDA -->
                                <td>{{ $movimiento->almacene->nombre ?? 'N/A' }}</td> <!-- Assumes 'almacene' relationship exists -->
                                <td>{{ $movimiento->usuario->persona->carnet ?? 'N/A' }}</td> <!-- Assumes 'operador' relationship exists -->
                                <td>{{ $movimiento->cliente->carnet ?? 'N/A' }}</td> <!-- Assumes 'cliente' relationship exists for VENTAS -->
                                <td>{{ $movimiento->recinto->nombre ?? 'N/A' }}</td> <!-- Assumes 'recinto' relationship exists for VENTAS -->
                                <td>{{ $movimiento->persona->carnet ?? 'N/A' }}</td> <!-- Assumes 'recinto' relationship exists for VENTAS -->
                                <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                                <td>{{ $movimiento->detalles->count() }}</td> <!-- Count of Detalles -->
                                <td>{{ number_format($movimiento->detalles->sum('total'), 2) }}</td> <!-- Sum of Detalle totals -->
                            </tr>

                            <!-- Expandable row for product details -->
                            <tr>
                                <td colspan="10">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($movimiento->detalles as $detalle)
                                                    <tr>
                                                        <td>{{ $detalle->producto->nombre }}</td>
                                                        <td>{{ $detalle->cantidad }}</td>
                                                        <td>{{ number_format($detalle->precio, 2) }}</td>
                                                        <td>{{ number_format($detalle->total, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
