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
                        Editar Detalles
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
                        <li class="breadcrumb-item" aria-current="page">
                            Editar Detalles
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ $movimiento->codigo }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de Detalles
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <form id="detallesForm" method="POST"
                    action="{{ route('movimientos.guardarDetalles', $movimiento->id_movimiento) }}">
                    @csrf
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                        <thead>
                            <tr>
                                <th class="text-center hide-on-small" style="width: 5%;">#</th>
                                <th style="width: 30%;">Producto</th>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="detallesBody">
                            @php
                                $totalPr = 0;
                            @endphp
                            @foreach ($detalles as $index => $detalle)
                                <tr data-index="{{ $index }}">
                                    <input type="hidden" class="sexo" name="productos[{{ $index }}][id_detalle]"
                                        value="{{ $detalle->id_detalle }}">
                                    <td class="text-center hide-on-small">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <select name="productos[{{ $index }}][id_producto]"
                                            class="form-control select-producto" required>
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($productos as $producto)
                                                <option value="{{ $producto->id_producto }}"
                                                    data-precio="{{ $producto->precio }}"
                                                    data-codigo="{{ $producto->codigo }}"
                                                    {{ $detalle->id_producto == $producto->id_producto ? 'selected' : '' }}>
                                                    [{{ $producto->codigo }}] {{ $producto->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="codigo-producto text-muted">{{ $detalle->producto->codigo }}</td>
                                    <td>
                                        <input type="number" name="productos[{{ $index }}][cantidad]"
                                            class="form-control cantidad" value="{{ $detalle->cantidad }}" min="1"
                                            required>
                                    </td>
                                    <td class="precio-producto text-muted">
                                        <input type="hidden" name="productos[{{ $index }}][precio]"
                                            value="{{ $detalle->precio }}">
                                        {{ number_format($detalle->precio, 2) }}
                                    </td>
                                    <td class="subtotal text-muted">{{ number_format($detalle->total, 2) }}</td>
                                    @php
                                        $totalPr += $detalle->total;
                                    @endphp
                                    <td>
                                        <button class="delete-row btn btn-danger"
                                            data-id-movimiento="{{ $movimiento->id_movimiento }}"
                                            data-id-detalle="{{ $detalle->id_detalle }}">
                                            Delete
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="5"><strong>TOTAL</strong></td>
                                <td colspan="2" id="total">{{ number_format($totalPr, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <button type="button" id="addRow" class="btn btn-success">Agregar Detalle</button>
                    <button type="submit" class="btn btn-primary">Guardar Detalles</button>
                </form>
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
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for product selection
            $('.select-producto').select2();

            // Update subtotal and total when product or quantity changes
            function updateSubtotal(row) {
                const cantidad = parseFloat(row.find('.cantidad').val()) || 0;
                const precio = parseFloat(row.find('.select-producto option:selected').data('precio')) || 0;
                const subtotal = cantidad * precio;

                row.find('.precio-producto').text(precio.toFixed(2));
                row.find('.subtotal').text(subtotal.toFixed(2));

                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                $('#detallesBody .subtotal').each(function() {
                    total += parseFloat($(this).text()) || 0;
                });
                $('#total').text(total.toFixed(2));
            }

            // Attach event listeners to existing rows
            $('#detallesBody').on('change', '.select-producto', function() {
                const row = $(this).closest('tr');
                row.find('.codigo-producto').text($(this).find('option:selected').data('codigo'));
                updateSubtotal(row);
            });

            $('#detallesBody').on('input', '.cantidad', function() {
                const row = $(this).closest('tr');
                updateSubtotal(row);
            });

            // Add new row
            $('#addRow').on('click', function() {
                const index = $('#detallesBody tr').length; // New row index based on existing rows
                const newRow = `
                    <tr data-index="${index}">
                        <td>${index + 1}</td>
                        <td>
                            <select name="productos[${index}][id_producto]" class="form-control select-producto" required>
                                <option value="">Seleccione un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}" data-codigo="{{ $producto->codigo }}">
                                        [{{ $producto->codigo }}] {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="codigo-producto"></td>
                        <td>
                            <input type="number" name="productos[${index}][cantidad]" class="form-control cantidad" value="1" min="1" required>
                        </td>
                        <td class="precio-producto">0.00</td>
                        <td class="subtotal">0.00</td>
                        <td>
                            <button type="button" class="delete-new-row btn btn-danger">
                                Delete
                            </button>
                        </td>
                    </tr>
                `;
                $('#detallesBody').append(newRow);
                $('.select-producto').select2(); // Reinitialize Select2 for new row
                updateSubtotal($('#detallesBody tr:last')); // Update subtotal for the new row
            });

            // Remove row
            $(document).on('click', '.delete-row', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var idMovimiento = $(this).data('id-movimiento');
                var idDetalle = $(this).data('id-detalle');
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this detail?')) {
                    $.ajax({
                        url: `/movimientos/${idMovimiento}/eliminarDetalle/${idDetalle}`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}' // Include CSRF token
                        },
                        success: function(response) {
                            alert(response.success); // Optionally show success message
                            $row.remove(); // Remove the row from the table
                            updateTotal(); // Recalculate the total after deletion
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the detail.');
                        }
                    });
                }
            });

            // Handle delete for newly added rows
            $('#detallesBody').on('click', '.delete-new-row', function(e) {
                e.preventDefault();
                var $row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this newly added detail?')) {
                    $row.remove(); // Remove the row from the table
                    updateTotal(); // Recalculate the total after deletion
                }
            });
        });
    </script>
@endsection
