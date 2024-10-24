@extends('layouts.backend')

@section('css')
    <!-- Add necessary CSS here -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            z-index: 9999 !important;
            /* Asegúrate de que esté sobre otros elementos */
        }

        .select2-dropdown {
            z-index: 99999 !important;
            width: 40vh !important;
            /* Asegura que el dropdown tenga un índice alto */
        }
    </style>
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
            <button id="añadirDetallesbtn" type="button" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
                <span class="d-none d-sm-inline">Añadir Producto</span>
            </button>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center hide-on-small" style="width: 5%;">#</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPr = 0; @endphp <!-- Initialize the total -->
                        @foreach ($detalles as $index => $detalle)
                            <tr>
                                <td class="text-center hide-on-small">{{ $loop->index + 1 }}</td>
                                <td class="text-muted">{{ $detalle->producto->nombre }}</td>
                                <td class="text-muted">{{ $detalle->producto->codigo }}</td>
                                <td class="text-muted">{{ $detalle->cantidad }}</td>
                                <td class="text-muted">{{ $detalle->precio }}</td>
                                <td class="text-muted">
                                    {{ $detalle->total }}
                                    @php
                                        $totalPr += $detalle->total;
                                    @endphp <!-- Add the subtotal to the running total -->
                                </td>
                                <td class="text-muted">
                                    <!-- Add an edit button here -->
                                    <button type="button" class="btn btn-sm btn-alt-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $detalle->id_detalle }}" title="Editar Detalle">
                                        <i class="fa fa-fw fa-pencil-alt"></i> Editar
                                        <!-- Edit button -->
                                    </button>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" class="editModal" id="editModal{{ $detalle->id_detalle }}"
                                        tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-xl"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Editar Producto en el
                                                        Movimiento</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editDetalleForm{{ $detalle->id_detalle }}"
                                                        action="{{ route('usuario.actualizarDetalle', $detalle->id_detalle) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <!-- Producto Field -->
                                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                                <label for="producto{{ $detalle->id_detalle }}"
                                                                    class="form-label">Producto</label>
                                                                <input type="text" class="form-control"
                                                                    id="producto{{ $detalle->id_detalle }}" name="producto"
                                                                    value="{{ $detalle->producto->nombre }}" readonly>
                                                            </div>

                                                            <!-- Cantidad Field -->
                                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                                <label for="cantidad{{ $detalle->id_detalle }}"
                                                                    class="form-label">Cantidad</label>
                                                                <input type="number" class="form-control"
                                                                    id="cantidad{{ $detalle->id_detalle }}" name="cantidad"
                                                                    min="1" value="{{ $detalle->cantidad }}"
                                                                    required>
                                                                <!-- Hidden container with the original cantidad of the detalle -->
                                                                <input type="hidden"
                                                                    id="originalCantidad{{ $detalle->id_detalle }}"
                                                                    name="originalCantidad"
                                                                    value="{{ $detalle->cantidad }}">
                                                            </div>
                                                            <!-- Precio Field -->
                                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                                <label for="precio{{ $detalle->id_detalle }}"
                                                                    class="form-label">Precio</label>
                                                                <input type="text" class="form-control"
                                                                    id="precio{{ $detalle->id_detalle }}" name="precio"
                                                                    value="{{ $detalle->producto->precio }}" readonly
                                                                    required>
                                                            </div>

                                                            <!-- Total Field -->
                                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                                <label for="total{{ $detalle->id_detalle }}"
                                                                    class="form-label">Subtotal</label>
                                                                <input type="text" class="form-control"
                                                                    id="total{{ $detalle->id_detalle }}" name="total"
                                                                    value="{{ $detalle->total }}" readonly required>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="idAlmacen{{ $detalle->id_detalle }}"
                                                            value="{{ $movimiento->id_almacen }}">
                                                        <input type="hidden"
                                                            id="tipoMovimiento{{ $detalle->id_detalle }}"
                                                            value="{{ $movimiento->tipo }}">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        form="editDetalleForm{{ $detalle->id_detalle }}"
                                                        class="btn btn-info">Actualizar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add a delete button here -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteDetalleModal"
                                        data-product-name="{{ $detalle->producto->nombre }}"
                                        data-movimiento-id="{{ $movimiento->id_movimiento }}"
                                        data-detalle-id="{{ $detalle->id_detalle }}">
                                        <i class="fa fa-trash"></i><small class="hide-on-small"> Eliminar</small>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right" colspan="5"><strong>TOTAL</strong></td>
                            <td colspan="1">{{ number_format($totalPr, 2) }}</td>
                            <!-- Display the total -->
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!--Añadir un botón para regresar a la pagina previa -->
            <button class="btn btn-secondary"
                onclick="window.location.href='{{ route('usuario.editMv', $movimiento->id_movimiento) }}'"> ←
                Regresar</button>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addDetalleModal" tabindex="-1" role="dialog" aria-labelledby="addDetalleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDetalleModalLabel">Añadir Producto al Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDetalleForm" action="{{ route('usuario.guardarDetalle', $movimiento->id_movimiento) }}"
                        method="POST">
                        @csrf
                        <div class="row mb-3">
                            <!-- Producto Field -->
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="producto" class="form-label">Producto</label></br>
                                <select class="form-control select-producto" id="producto" name="producto" required>
                                    <option value="">Seleccione un Producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id_producto }}"
                                            data-precio="{{ $producto->precio }}">
                                            [{{ $producto->codigo }}] {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cantidad Field -->
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad"
                                    min="1" value="1" required>
                            </div>
                            <!-- Precio Field -->
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio" readonly>
                            </div>

                            <!-- Total Field -->
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="total" class="form-label">Total</label>
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>
                        <input type="hidden" id="idAlmacen" value="{{ $movimiento->id_almacen }}">
                        <input type="hidden" id="tipoMovimiento" value="{{ $movimiento->tipo }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addDetalleForm" class="btn btn-success">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="border: 3px solid rgb(179, 6, 6); border-radius: 10px;" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="modal-header rounded bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="errorList"></ul> <!-- This will be populated with error messages -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Button to trigger the modal -->
    <script>
        document.getElementById('añadirDetallesbtn').addEventListener('click', function() {
            $('#addDetalleModal').modal('show');
        });
    </script>


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

    <!-- Modal de confirmación para eliminar detalle -->
    <div class="modal fade" id="confirmDeleteDetalleModal" tabindex="-1"
        aria-labelledby="confirmDeleteDetalleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteDetalleModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar el producto <strong id="product-name"></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteDetalleForm" method="POST" action="">
                        @csrf
                        @method('POST')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteModal = document.getElementById('confirmDeleteDetalleModal');

            confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productName = button.getAttribute('data-product-name');
                const movimientoId = button.getAttribute('data-movimiento-id');
                const detalleId = button.getAttribute('data-detalle-id');

                // Actualizar el contenido del modal
                const modalProductName = confirmDeleteModal.querySelector('#product-name');
                modalProductName.textContent = productName;

                // Actualizar la acción del formulario
                const deleteForm = confirmDeleteModal.querySelector('#deleteDetalleForm');
                const newAction =
                    `{{ route('usuario.eliminarDetalle', ['id_movimiento' => ':movimientoId', 'id_detalle' => ':detalleId']) }}`
                    .replace(':movimientoId', movimientoId)
                    .replace(':detalleId', detalleId);
                deleteForm.action = newAction;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 within the modal when it's shown
            $('#addDetalleModal').on('shown.bs.modal', function() {
                $('.select-producto').select2({
                    dropdownParent: $(
                        '#addDetalleModal') // Para asegurar que el dropdown se adjunta al modal
                });
            });

            // Asignar el evento cuando se selecciona un producto en el modal
            $('#addDetalleModal').on('change', '#producto', function() {
                var selectedProduct = $(this).find('option:selected');
                var precio = selectedProduct.data('precio');

                // Set the price in the precio input field
                $('#precio').val(precio);

                // Calculate and set the total
                var cantidad = $('#cantidad').val();
                var total = (cantidad * precio).toFixed(2);
                $('#total').val(total);
            });

            // Cuando cambia la cantidad, actualiza el total
            $('#addDetalleModal').on('input', '#cantidad', function() {
                var cantidad = $(this).val();
                var precio = $('#precio').val();

                // Calcular el total y actualizar el campo de total
                var total = (cantidad * precio).toFixed(2);
                $('#total').val(total);
            });

            $(document).on('submit', '#addDetalleForm', function(event) {
                event.preventDefault(); // Prevenir la sumisión predeterminada del formulario

                // Recolectar los datos del formulario
                const formData = $(this).serializeArray();
                const cantidadSolicitada = formData.find(item => item.name === 'cantidad').value;
                const productoID = formData.find(item => item.name === 'producto').value;

                // Obtener el nombre del producto a partir del select
                const productoNombre = $('#producto option:selected').text().replace(/\[.*?\]/, '').trim();

                // Obtener otros datos del movimiento
                const tipoMovimiento = $('#tipoMovimiento').val();
                const idAlmacen = $('#idAlmacen').val();
                const csrfToken = '{{ csrf_token() }}';

                console.log(tipoMovimiento, idAlmacen, productoNombre,
                    cantidadSolicitada); // Agregar esta línea para depurar
                // Establecer la URL según el tipo de movimiento
                let url;
                if (tipoMovimiento === 'SALIDA') {
                    url = '{{ route('usuario.checkAvailability') }}';
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        almacene: idAlmacen,
                        producto: productoNombre,
                        cantidad: cantidadSolicitada,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.available) {
                            // Si la validación pasa, proceder a enviar el formulario
                            $('#addDetalleForm')[0].submit();
                        } else {
                            // Manejar la respuesta de error
                            let errorMessage = '';
                            if (tipoMovimiento === 'SALIDA') {
                                errorMessage =
                                    `No existen suficientes unidades de ${response.productName}, en el almacen: ${response.almacenName}. Cantidad disponible: ${response.cantidadDisponible}`;
                            } else {
                                errorMessage = response.message;
                            }
                            $('#errorList').empty().append(`<li>${errorMessage}</li>`);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = $('#errorList');
                        errorList.empty();
                        $.each(errors, function(key, value) {
                            errorList.append(`<li>${value[0]}</li>`);
                        });
                        $('#errorModal').modal('show');
                    }
                });
            });


            //PROCESOS PARA EL MODAL DE ACTUALIZACIÓN;

            // Cuando cambia la cantidad, actualiza el total
            $(document).on('show.bs.modal', '[id^="editModal"]', function(event) {
                // When the modal is shown, store the original values
                const modal = $(this);

                // Store original values in data attributes
                modal.find('input[name="cantidad"]').each(function() {
                    $(this).data('original-value', $(this).val());
                });
                modal.find('input[name="precio"]').each(function() {
                    $(this).data('original-value', $(this).val());
                });
                modal.find('input[name="total"]').each(function() {
                    $(this).data('original-value', $(this).val());
                });
            });

            $(document).on('hidden.bs.modal', '[id^="editModal"]', function(event) {
                // When the modal is hidden, restore the original values
                const modal = $(this);

                // Reset values to original ones stored in data attributes
                modal.find('input[name="cantidad"]').each(function() {
                    $(this).val($(this).data('original-value'));
                });
                modal.find('input[name="precio"]').each(function() {
                    $(this).val($(this).data('original-value'));
                });
                modal.find('input[name="total"]').each(function() {
                    $(this).val($(this).data('original-value'));
                });
                var form = $(this).find('form');
                form.data('submitted', false); // Reset the submitted flag when the modal closes
            });

            // Event listener for recalculating total when the quantity is changed
            $(document).on('input', '[id^="editModal"] input[name="cantidad"]', function() {
                const modal = $(this).closest('.modal');
                const cantidad = $(this).val();
                const precio = modal.find('input[name="precio"]').val();

                // Calculate and update the total
                const total = (cantidad * precio).toFixed(2);
                modal.find('input[name="total"]').val(total);
            });

            $(document).on('submit', 'form[id^="editDetalleForm"]', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Store reference to the form that triggered the event
                var form = $(this);
                // Extract the detalle ID from the form ID
                var detalleId = form.attr('id').replace('editDetalleForm', '');

                // Prevent duplicate submissions with a flag
                if (form.data('submitted') === true) {
                    return false;
                }
                // Gather form data
                const formData = form.serializeArray();
                const cantidadSolicitada = formData.find(item => item.name === 'cantidad').value - formData
                    .find(item => item.name === 'originalCantidad')
                    .value; // Calculate the difference between the new and original quantity

                const productoNombre = $(`#producto${detalleId}`).val();

                // Get other movement data using dynamic IDs
                const tipoMovimiento = $(`#tipoMovimiento${detalleId}`).val();
                const idAlmacen = $(`#idAlmacen${detalleId}`).val();
                const csrfToken = '{{ csrf_token() }}';
                // Set the URL based on movement type
                let url;
                if (tipoMovimiento === 'SALIDA') {
                    url = '{{ route('usuario.checkAvailability') }}';
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        almacene: idAlmacen,
                        cantidad: cantidadSolicitada,
                        producto: productoNombre, // Pass the product name from the input field
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.available) {
                            // If validation passes, prevent duplicate submissions and submit the form
                            console.log("HAS BEEN SUBMITTED!");
                            form.data('submitted', true); // Mark form as submitted
                            form[0].submit(); // Submit the form programmatically
                        } else {
                            // Handle the error response
                            let errorMessage = '';
                            if (tipoMovimiento === 'SALIDA') {
                                errorMessage =
                                    `No existen suficientes unidades de ${response.productName}, en el almacen: ${response.almacenName}. Cantidad disponible: ${response.cantidadDisponible}`;
                            } else {
                                errorMessage = response.message;
                            }
                            $('#errorList').empty().append(`<li>${errorMessage}</li>`);
                            $('#errorModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = $('#errorList');
                        errorList.empty();
                        $.each(errors, function(key, value) {
                            errorList.append(`<li>${value[0]}</li>`);
                        });
                        $('#errorModal').modal('show');
                    }
                });
            });

        });
    </script>
@endsection
