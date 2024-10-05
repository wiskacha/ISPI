@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        @media (max-width: 1328px) {
            .hide-on-small {
                display: none;
            }
        }
    </style>
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Page JS Code -->
    {{-- @vite(['resources/js/pages/datatables.js']) --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoPagoSelect = document.getElementById('tipo_pago');
            const contadoFields = document.getElementById('contadoFields');
            const creditoFields = document.getElementById('creditoFields');
            const clienteSelect = document.getElementById('cliente_select');
            const cantidadCuotasField = document.getElementById('cantidad_cuotas');
            const aditivoField = document.querySelector('input[name="aditivo"]');
            const primerPagoField = document.querySelector('input[name="primer_pago"]');

            // Listener for payment type selection
            tipoPagoSelect.addEventListener('change', function() {
                const tipo = this.value;
                // Show/hide respective fields based on payment type
                contadoFields.style.display = tipo === 'CONTADO' ? 'block' : 'none';
                creditoFields.style.display = tipo === 'CRÉDITO' ? 'block' : 'none';

                // Update the required attribute and form validation for 'CRÉDITO'
                toggleCreditoRequiredFields(tipo);

                // Show/hide client field based on payment type
                toggleClienteField(tipo);

                // Update preview for CONTADO
                updateContadoPreview();
            });

            // Listener for fields affecting the preview
            const inputFields = ['descuento', 'aditivo', 'cantidad_cuotas', 'primer_pago'];
            inputFields.forEach(id => {
                document.querySelector(`input[name="${id}"]`).addEventListener('input', function() {
                    updateContadoPreview();
                    if (tipoPagoSelect.value === 'CRÉDITO') {
                        updateCreditoTable();
                    }
                });
            });

            // Function to toggle required fields for 'CRÉDITO'
            function toggleCreditoRequiredFields(tipo) {
                if (tipo === 'CRÉDITO') {
                    updateContadoPreview();
                    cantidadCuotasField.setAttribute('required', 'required');
                    aditivoField.setAttribute('required', 'required');
                    primerPagoField.setAttribute('required', 'required');
                } else {
                    cantidadCuotasField.removeAttribute('required');
                    aditivoField.removeAttribute('required');
                    primerPagoField.removeAttribute('required');
                }
            }

            // Function to show/hide client field
            function toggleClienteField(tipo) {
                if (tipo === 'CRÉDITO') {
                    clienteSelect.style.display = 'block';
                    clienteSelect.setAttribute('required', 'required');
                } else {
                    clienteSelect.removeAttribute('required');
                }
            }

            // Function to update the CONTADO payment preview
            function updateContadoPreview() {
                const descuento = parseFloat(document.querySelector('input[name="descuento"]').value) || 0;
                const total = {{ $total }};
                const montoPagar = total - descuento;
                document.getElementById('montoPagar').innerText = montoPagar.toFixed(2);
                document.getElementById('montoPagado').innerText = montoPagar.toFixed(2);
            }

            // Function to update the cuotas table for 'CRÉDITO'
            function updateCreditoTable() {
                const cantidadCuotas = parseInt(document.getElementById('cantidad_cuotas').value) || 0;
                const aditivo = parseFloat(aditivoField.value) || 0;
                const primerPago = parseFloat(primerPagoField.value) || 0;
                const total = {{ $total }};
                const totalConAditivo = total + aditivo;
                const montoPagar = Math.ceil(totalConAditivo / cantidadCuotas);
                const tableBody = document.querySelector('#cuotasTable tbody');
                tableBody.innerHTML = ''; // Clear previous rows

                let montoPagado = primerPago;
                let montoAdeudado;

                for (let i = 1; i <= cantidadCuotas; i++) {
                    const row = document.createElement('tr');

                    // Calculate montoAdeudado and estado based on previous payments
                    if (montoPagado >= montoPagar) {
                        montoAdeudado = 0; // Fully paid
                        row.innerHTML = `
                <td>${i}</td>
                <td>CT${i}-${Date.now()}</td>
                <td>Cuota #${i}</td>
                <td>${new Date(Date.now() + (i - 1) * 30 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10)}</td>
                <td>${montoPagar.toFixed(2)}</td>
                <td>${montoPagar.toFixed(2)}</td>
                <td>${montoAdeudado.toFixed(2)}</td>
                <td>PAGADA</td>
            `;
                        montoPagado -= montoPagar; // Reduce amount paid
                    } else {
                        montoAdeudado = montoPagar - montoPagado; // Remaining amount
                        row.innerHTML = `
                <td>${i}</td>
                <td>CT${i}-${Date.now()}</td>
                <td>Cuota #${i}</td>
                <td>${new Date(Date.now() + (i - 1) * 30 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10)}</td>
                <td>${montoPagar.toFixed(2)}</td>
                <td>${montoPagado.toFixed(2)}</td>
                <td>${montoAdeudado.toFixed(2)}</td>
                <td>PENDIENTE</td>
            `;
                        montoPagado = 0; // All remaining payment is used
                    }

                    tableBody.appendChild(row);
                }
            }



            // Preload client data if already set and the payment type is 'CRÉDITO'
            const clienteId = "{{ $movimiento->id_cliente }}";
            if (clienteId && tipoPagoSelect.value === 'CRÉDITO') {
                clienteSelect.value = clienteId;
                clienteSelect.style.display = 'block';
                clienteSelect.setAttribute('required', 'required');
            }

            // Confirm form submission with user confirmation
            // document.querySelector('form').addEventListener('submit', function(event) {
            //     if (!confirm('¿Está seguro de que desea guardar los cambios?')) {
            //         event.preventDefault();
            //     }
            // });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Apply Select2 to the ID Empresa field
            $('#cliente_select').select2({
                placeholder: "Selecciona un cliente",
                allowClear: true,

            });
        });
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Asignación de Cuotas</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Cuotas</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item"><a class="link-fx" href="javascript:void(0)">Movimientos</a></li>
                        <li class="breadcrumb-item" aria-current="page">Cuotas</li>
                        <li class="breadcrumb-item" aria-current="page">Asignación de Cuotas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded mt-3 mx-3">
        <div class="block-header block-header-default">
            <h3 class="block-title">Asignación de Cuotas</h3>
        </div>
        <div class="container">
            <form action="{{ route('movimientos.storeCuotas') }}" method="POST">
                @csrf
                <input type="hidden" name="id_movimiento" value="{{ $movimiento->id_movimiento }}">

                <!-- Tipo de Pago y Cliente al mismo nivel -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_pago" class="form-label">Tipo de Pago:</label>
                        <select name="tipo_pago" id="tipo_pago" class="form-select" required>
                            <option value="" selected>Seleccionar tipo de pago</option>
                            <option value="CONTADO">CONTADO</option>
                            <option value="CRÉDITO">CRÉDITO</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-end">
                        <label for="cliente_select" class="form-label">Seleccionar Cliente:</label>
                        <select name="id_cliente" id="cliente_select" class="form-select">
                            <option value="">Seleccione un Cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id_persona }}"
                                    {{ $movimiento->id_cliente == $cliente->id_persona ? 'selected' : '' }}>
                                    {{ $cliente->papellido }} [{{ $cliente->carnet }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="contadoFields" class="mb-3" style="display: none;">
                    <label for="descuento" class="form-label">Descuento:</label>
                    <input type="number" name="descuento" class="form-control" step="0.01" min="0"
                        value="{{ old('descuento') }}">
                    <h3 class="mt-3">Vista Previa Cuota</h3>
                    <div id="cuotaPreview" class="alert alert-info">
                        <p>Número: 1</p>
                        <p>Código: CT-{{ now()->timestamp }}</p>
                        <p>Concepto: Pago único</p>
                        <p>Fecha Vencimiento: {{ now()->toDateString() }}</p>
                        <p>Monto a Pagar: <span id="montoPagar">{{ number_format($total, 2) }} -
                                {{ old('descuento', 0) }}</span></p>
                        <p>Monto Pagado: <span id="montoPagado">{{ number_format($total, 2) }} -
                                {{ old('descuento', 0) }}</span></p>
                        <p>Monto Adeudado: 0</p>
                        <p>Condición: PAGADA</p>
                    </div>
                </div>

                <div id="creditoFields" class="mb-3" style="display: none;">
                    <label for="aditivo" class="form-label">Aditivo:</label>
                    <input type="number" name="aditivo" class="form-control" step="0.01" min="0"
                        value="{{ old('aditivo') }}">
                    <label for="cantidad_cuotas" class="form-label">Cantidad de Cuotas:</label>
                    <input type="number" name="cantidad_cuotas" id="cantidad_cuotas" class="form-control" min="1"
                        required>
                    <label for="primer_pago" class="form-label">Primer Pago:</label>
                    <input type="number" name="primer_pago" class="form-control" step="0.01" min="0"
                        value="{{ old('primer_pago') }}">
                    <h3 class="mt-3">Detalles de Cuotas</h3>
                    <div class="table-responsive">
                        <table id="cuotasTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Código</th>
                                    <th>Concepto</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Monto</th>
                                    <th>Pagado</th>
                                    <th>Adeudado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas de cuotas se agregarán dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection
