@extends('layouts.backend')

@section('css')
    <style>
        .step-container {
            display: none;
        }

        .active-step {
            display: block;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Registro de Movimiento
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
                            Registro de Movimiento
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">Registro de Movimiento</h3>
        </div>

        <div class="block-content block-content-full">
            <!-- Step 1: Operador -->
            <div class="step-container active-step" id="step-1">
                <h4>Operación a cargo de:</h4>
                <p>{{ Auth::user()->persona->papellido }} - [{{ Auth::user()->persona->carnet }}]</p>
                <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                    <button class="btn btn-alt-primary" onclick="nextStep(2)"
                        style="margin-bottom: 1rem;">Siguiente</button>
                </div>
            </div>

            <!-- Step 2: Almacene and Tipo -->
            <div class="step-container" id="step-2">
                <div class="mb-4">
                    <label for="almacene" class="form-label">Seleccione Almacén:</label>
                    <select class="form-control" id="almacene" name="almacene">
                        @foreach ($almacenes as $almacene)
                            <option value="{{ $almacene->id_almacen }}">{{ $almacene->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tipo" class="form-label">Tipo de Movimiento:</label>
                    <select class="form-control" id="tipo" name="tipo" onchange="handleTipoChange()">
                        <option value="ENTRADA">ENTRADA</option>
                        <option value="SALIDA">SALIDA</option>
                    </select>
                </div>
                <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                    <button class="btn btn-secondary me-2" onclick="previousStep(1)"
                        style="margin-bottom: 1rem;">Atrás</button>
                    <button class="btn btn-alt-primary" onclick="nextStep(3)"
                        style="margin-bottom: 1rem;">Siguiente</button>
                </div>
            </div>

            <!-- Step 3: Based on Tipo -->
            <div class="step-container" id="step-3">
                <div id="entrada-fields" style="display:none;">
                    <label for="proveedor" class="form-label">Seleccione Proveedor:</label>
                    <select class="form-control" id="proveedor" name="proveedor">
                        @foreach ($proveedores as $persona)
                            <option value="{{ $persona->id_persona }}">{{ $persona->papellido }} - [{{ $persona->carnet }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="salida-fields" style="display:none;">
                    <label for="cliente" class="form-label">Seleccione Cliente:</label>
                    <select class="form-control" id="cliente" name="cliente">
                        <option value="">(Optional)</option>
                        @foreach ($clientes as $persona)
                            <option value="{{ $persona->id_persona }}">{{ $persona->papellido }} - [{{ $persona->carnet }}]
                            </option>
                        @endforeach
                    </select>

                    <label for="recinto" class="form-label mt-4">Seleccione Recinto:</label>
                    <select class="form-control" id="recinto" name="recinto">
                        <option value="">(Optional)</option>
                        @foreach ($recintos as $recinto)
                            <option value="{{ $recinto->id_recinto }}">{{ $recinto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                    <button class="btn btn-secondary me-2" onclick="previousStep(2)"
                        style="margin-bottom: 1rem; margin-top: 1rem;">Atrás</button>
                    <button class="btn btn-alt-primary" onclick="nextStep(4)"
                        style="margin-bottom: 1rem; margin-top: 1rem;">Siguiente</button>
                </div>
            </div>

            <!-- Step 4: Detalles Table -->
            <div class="step-container" id="step-4">
                <h4>Detalles</h4>
                <div class="table-responsive">
                    <table id="detalle-table" class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <td id="total-amount">0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button class="btn btn-alt-success" onclick="addDetalleRow()"> <i class="fa fa-plus"></i> Añadir
                    producto</button>

                <div class="mt-4">
                    <label for="glose" class="form-label">Glose:</label>
                    <textarea id="glose" name="glose" class="form-control" style="margin-bottom: 1rem;"></textarea>
                </div>
                <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                    <button class="btn btn-secondary me-2" onclick="previousStep(3)"
                        style="margin-bottom: 1rem;">Atrás</button>
                    <button class="btn btn-alt-primary" onclick="nextStep(5)"
                        style="margin-bottom: 1rem;">Siguiente</button>
                </div>
            </div>

            <!-- Step 5: Preview -->
            <div class="step-container" id="step-5">
                <h4>Confirmación de Movimiento</h4>
                <div id="preview-content">
                    <!-- Generate a summary of all fields filled out in the wizard -->
                </div>
                <form id="hidden-form" action="{{ route('movimientos.store') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="almacene" id="almacene-hidden">
                    <input type="hidden" name="tipo" id="tipo-hidden">
                    <input type="hidden" name="proveedor" id="proveedor-hidden">
                    <input type="hidden" name="cliente" id="cliente-hidden">
                    <input type="hidden" name="recinto" id="recinto-hidden">
                    <input type="hidden" name="glose" id="glose-hidden">
                    <input type="hidden" name="productos[]" id="productos-hidden">
                    <input type="hidden" name="cantidad[]" id="cantidad-hidden">
                    <input type="hidden" name="precio[]" id="precio-hidden">
                    <input type="hidden" name="subtotal[]" id="subtotal-hidden">
                    <input type="hidden" name="total" id="total-hidden">
                </form>

                <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                    <button class="btn btn-secondary" onclick="previousStep(4)"
                        style="margin-bottom: 1rem; margin-right: 1rem;">Atrás</button>
                    <button type="button" class="btn btn-success me-2" id="confirm-button" data-bs-toggle="modal"
                        data-bs-target="#confirmationModal" style="margin-bottom: 1rem;">Confirmar Movimiento</button>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmar Movimiento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de que deseas confirmar este movimiento?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" id="submit-confirm">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('confirm-button').addEventListener('click', function() {
                        document.getElementById('submit-confirm').addEventListener('click', function() {
                            document.getElementById('hidden-form').submit();
                        });
                    });
                </script>
            </div>
            <div class="col-12 col-lg-6 ms-left d-flex" style="justify-content: flex-start;">
                <button class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#cancelConfirmationModal">Cancelar</button>
            </div>
        </div>
    </div>
    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelConfirmationModalLabel">Cancelar Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea cancelar este movimiento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="submit-cancel"
                        onclick="window.location.href='{{ route('movimientos.vista') }}'">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Invalid Row Modal -->
    <div class="modal fade" id="invalidRowModal" tabindex="-1" aria-labelledby="invalidRowModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header rounded-top bg-warning">
                    <h5 class="modal-title" id="invalidRowModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="invalidRowsModalBody">
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
                </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            handleTipoChange(); // This ensures the correct fields are shown based on the default selection.
            document.getElementById('submit-button').onclick = function() {
                document.getElementById('hidden-form').submit();
            };
        });
    </script>

    <script>
        $(document).ready(function() {
            // Apply Select2 to all select elements on the page
            $('select').select2({
                placeholder: function() {
                    // Apply different placeholders based on the select element's ID
                    if ($(this).attr('id') === 'almacene') {
                        return "Seleccione un almacén";
                    } else if ($(this).attr('id') === 'tipo') {
                        return "Seleccione el tipo de movimiento";
                    } else if ($(this).attr('id') === 'proveedor') {
                        return "Seleccione un proveedor";
                    } else if ($(this).attr('id') === 'cliente') {
                        return "Seleccione un cliente";
                    } else if ($(this).attr('id') === 'recinto') {
                        return "Seleccione un recinto";
                    } else {
                        return "Seleccione una opción";
                    }
                },
                allowClear: false // You can toggle this to true if you'd like a clear button for selects
            });

            // Reapply Select2 when navigating through steps to ensure Select2 is applied
            $('button').on('click', function() {
                setTimeout(function() {
                    $('select').select2({
                        placeholder: function() {
                            // Apply different placeholders based on the select element's ID
                            if ($(this).attr('id') === 'almacene') {
                                return "Seleccione un almacén";
                            } else if ($(this).attr('id') === 'tipo') {
                                return "Seleccione el tipo de movimiento";
                            } else if ($(this).attr('id') === 'proveedor') {
                                return "Seleccione un proveedor";
                            } else if ($(this).attr('id') === 'cliente') {
                                return "Seleccione un cliente";
                            } else if ($(this).attr('id') === 'recinto') {
                                return "Seleccione un recinto";
                            } else {
                                return "Seleccione una opción";
                            }
                        },
                        allowClear: false
                    });
                }, 100); // Ensure the step is fully rendered before reapplying Select2
            });
        });
    </script>

    <script>
        let currentStep = 1;

        function nextStep(step) {
            // If moving to the preview step, validate first
            if (step === 5) {
                if (!validateAndCleanupRows()) {
                    return; // Don't proceed if validation fails
                }
                generatePreview(); // Move preview generation here after validation
            }
            // Move to the next step
            document.getElementById('step-' + currentStep).classList.remove('active-step');
            document.getElementById('step-' + step).classList.add('active-step');
            currentStep = step;
        }

        function previousStep(step) {
            document.getElementById('step-' + currentStep).classList.remove('active-step');
            document.getElementById('step-' + step).classList.add('active-step');
            currentStep = step;
        }

        function handleTipoChange() {
            const tipo = document.getElementById('tipo').value;
            document.getElementById('entrada-fields').style.display = tipo === 'ENTRADA' ? 'block' : 'none';
            document.getElementById('salida-fields').style.display = tipo === 'SALIDA' ? 'block' : 'none';
        }

        function addDetalleRow() {
            const tbody = document.querySelector('#detalle-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select class="form-control" name="productos[]" onchange="updatePrecio(this)">
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control" name="cantidad[]" onchange="calculateSubtotal(this)" min="0" value="0" /></td>
                <td class="precio">0</td>
                <td class="subtotal">0</td>
                <td><button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button></td>
            `;
            tbody.appendChild(row);
        }

        function updatePrecio(select) {
            const row = select.closest('tr');
            const selectedOption = select.options[select.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio') || 0;
            row.querySelector('.precio').innerText = precio;
            calculateSubtotal(select);
        }

        function deleteRow(button) {
            const row = button.closest('tr');
            row.remove();
            calculateTotal();
        }

        function calculateSubtotal(input) {
            const row = input.closest('tr');
            const cantidad = row.querySelector('input[name="cantidad[]"]').value || 0;
            const precio = row.querySelector('.precio').innerText || 0;
            const subtotal = cantidad * precio;
            row.querySelector('.subtotal').innerText = subtotal;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const subtotals = document.querySelectorAll('.subtotal');
            subtotals.forEach(subtotal => {
                total += parseFloat(subtotal.innerText) || 0;
            });
            document.getElementById('total-amount').innerText = total;
        }

        function validateAndCleanupRows() {
            const rows = document.querySelectorAll('#detalle-table tbody tr');
            let isValid = true;
            let hasValidRow = false;

            const invalidRows = [];
            rows.forEach(row => {
                const cantidadInput = row.querySelector('input[name="cantidad[]"]');
                const cantidad = parseInt(cantidadInput.value);
                const subtotalDisplay = row.querySelector('.subtotal').innerText;
                const subtotal = parseFloat(subtotalDisplay);

                if (isNaN(cantidad) || cantidad < 1 || subtotal <= 0) {
                    invalidRows.push(row);
                    isValid = false;
                } else {
                    hasValidRow = true;
                }
            });

            invalidRows.forEach(row => row.remove());

            if (!hasValidRow) {
                const invalidRowsModal = new bootstrap.Modal(document.getElementById('invalidRowModal'));
                document.getElementById('invalidRowsModalBody').innerHTML =
                    'Al menos debe existir un producto con cantidad y subtotal válido.';
                invalidRowsModal.show();
                isValid = false;
            }

            calculateTotal();
            return isValid;
        }

        function generatePreview() {
            const operador = "{{ Auth::user()->persona->papellido }} - [{{ Auth::user()->persona->carnet }}]";
            const almacene = document.getElementById('almacene').selectedOptions[0].text;
            const tipo = document.getElementById('tipo').value;
            const proveedor = tipo === 'ENTRADA' ? document.getElementById('proveedor').selectedOptions[0].text : 'N/A';
            const cliente = tipo === 'SALIDA' ? document.getElementById('cliente').selectedOptions[0].text : 'N/A';
            const recinto = tipo === 'SALIDA' ? document.getElementById('recinto').selectedOptions[0].text : 'N/A';

            const rows = document.querySelectorAll('#detalle-table tbody tr');
            let detalles = [];
            rows.forEach(row => {
                const producto = row.querySelector('select[name="productos[]"]').selectedOptions[0].text;
                const cantidad = row.querySelector('input[name="cantidad[]"]').value;
                const precio = row.querySelector('.precio').innerText;
                const subtotal = row.querySelector('.subtotal').innerText;

                detalles.push({
                    producto,
                    cantidad,
                    precio,
                    subtotal
                });
            });
            const glose = document.getElementById('glose').value || 'No glose provided';
            const total = document.getElementById('total-amount').innerText;

            const previewContent = `
                <p><strong>Operador:</strong> ${operador}</p>
                <p><strong>Almacén:</strong> ${almacene}</p>
                <p><strong>Tipo:</strong> ${tipo}</p>
                <p><strong>Proveedor:</strong> ${proveedor}</p>
                <p><strong>Cliente:</strong> ${cliente}</p>
                <p><strong>Recinto:</strong> ${recinto}</p>
                <h5>Detalles</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${detalles.map(det => `
                                                                                <tr>
                                                                                    <td>${det.producto}</td>
                                                                                    <td>${det.cantidad}</td>
                                                                                    <td>${det.precio}</td>
                                                                                    <td>${det.subtotal}</td>
                                                                                </tr>
                                                                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <p><strong>Total:</strong> ${total}</p>
                <p><strong>Glose:</strong> ${glose}</p>
            `;
            document.getElementById('preview-content').innerHTML = previewContent;

            // Prepare hidden inputs for submission
            document.getElementById('almacene-hidden').value = document.getElementById('almacene').value;
            document.getElementById('tipo-hidden').value = tipo;
            document.getElementById('proveedor-hidden').value = tipo === 'ENTRADA' ? document.getElementById('proveedor')
                .value : '';
            document.getElementById('cliente-hidden').value = tipo === 'SALIDA' ? document.getElementById('cliente').value :
                '';
            document.getElementById('recinto-hidden').value = tipo === 'SALIDA' ? document.getElementById('recinto').value :
                '';
            document.getElementById('glose-hidden').value = document.getElementById('glose').value;
            document.getElementById('total-hidden').value = total;

            // Gather product details
            const productos = [];
            const cantidad = [];
            const precio = [];
            const subtotal = [];

            detalles.forEach(det => {
                productos.push(det.producto);
                cantidad.push(det.cantidad);
                precio.push(det.precio);
                subtotal.push(det.subtotal);
            });

            document.getElementById('productos-hidden').value = JSON.stringify(productos);
            document.getElementById('cantidad-hidden').value = JSON.stringify(cantidad);
            document.getElementById('precio-hidden').value = JSON.stringify(precio);
            document.getElementById('subtotal-hidden').value = JSON.stringify(subtotal);
        }
    </script>
@endsection
