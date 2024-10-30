@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        @media (max-width: 1400px) {
            .hide-on-small {
                display: none;
            }
        }

        /* label bottom-margin 0.5rem */
        label {
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;
        }

        .content-container {
            margin: 1%;
            max-width: 100%;
            padding: 0 15px;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control-lg {
            font-size: 1.125rem;
            padding: .75rem 1.25rem;
        }

        .form-group {
            margin-bottom: 15px;
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
    <!-- Include jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>


    @vite(['resources/js/pages/datatables.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (!confirmDeleteModal) {
                return;
            }

            confirmDeleteModal.addEventListener('show.bs.modal', function(event) {

                const button = event.relatedTarget;

                const productName = button.getAttribute('data-product-name');
                const productId = button.getAttribute('data-product-id');

                // Actualizar el contenido del modal
                const modalProductName = confirmDeleteModal.querySelector('#product-name');
                modalProductName.textContent = productName;

                // Actualizar la acción del formulario usando la ruta nombrada
                const deleteForm = confirmDeleteModal.querySelector('#deleteProductForm');
                const newAction = `{{ route('productos.destroy', 'id') }}`.replace('id', productId);
                deleteForm.action = newAction;

            });
        });
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Ver Productos
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Visualizar productos
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Productos
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Vista de Productos
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @if ($errors->any() || session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Lista de PRODUCTOS <small>Exportable</small>
            </h3>
        </div>
        <div class="block-content block-content-full overflow-x-auto">
            <!-- DataTables init on table by adding .js-dataTable-responsive class -->
            <div style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                    <thead>
                        <tr>
                            <th class="text-center fs-sm" style="display: none">#</th>
                            <th style="width: auto%;">Imagen</th>
                            <th>Nombre Completo</th>
                            <th style="width: 6%;">Tags</th>
                            <th style="width: 10%;">Código</th>
                            <th style="width: 10%;">Precio</th>
                            <th style="width: 10%;">Presentación</th>
                            <th style="width: 20%;">Empresa</th> <!-- New column -->
                            <th class="text-center" style="width: auto;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $index => $producto)
                            <tr>
                                <td class="text-center fs-sm" style="display: none">{{ $index + 1 }}</td>
                                <td>
                                    @if ($producto->image_base64)
                                        <img src="data:image/jpeg;base64,{{ $producto->image_base64 }}"
                                            alt="{{ $producto->nombre }}" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <img src="https://via.placeholder.com/100" alt="No Image"
                                            style="max-height: 100%; max-width: 100%; height: auto;">
                                    @endif
                                </td>
                                <td class="fw-semibold fs-sm">{{ $producto->nombre }}</td>
                                <td class="fs-sm">
                                    @php
                                        $tags = json_decode($producto->tags, true);
                                        echo is_array($tags)
                                            ? implode('<br>', array_map(fn($tag) => "$tag", $tags))
                                            : 'N/A';
                                    @endphp
                                </td>
                                <td class="fs-sm">{{ $producto->codigo }}</td>
                                <td class="fs-sm">${{ number_format($producto->precio, 2) }}</td>
                                <td class="fs-sm">{{ 'U:' . $producto->unidad . ' / ' . $producto->presentacion }}</td>
                                <td class="fs-sm">{{ $producto->empresa ? $producto->empresa->nombre : 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="row" style="width: 100%; text-align: center;">
                                        <div class="col-md-6">
                                            <!-- Botón Editar (Left) -->
                                            <a href="{{ route('productos.edit', $producto->id_producto) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i><small class="hide-on-small">Editar</small>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal"
                                                data-product-name="{{ $producto->nombre }}"
                                                data-product-id="{{ $producto->id_producto }}">
                                                <i class="fa fa-trash"></i>
                                                <span class="hide-on-small">Eliminar</span>
                                            </button>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button id="customPrintButton">IMPRIMIR Products</button>
        </div>
    </div>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar a <strong id="product-name"></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteProductForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#customPrintButton').on('click', function() {
                printTable();
            });

            function printTable() {
                // Ensure the table exists
                if ($('.js-dataTable-responsive').length === 0) {
                    console.error("Table not found!");
                    return;
                }

                // Create a new table for the PDF without the "Acciones" column
                var newTable = $('<table></table>').css({
                    'width': '100%',
                    'border-collapse': 'collapse',
                    'position': 'absolute',
                    'top': '-9999px',
                    'font-size': '26px' // Move it off-screen
                });

                // Add headers to the new table
                var headerRow = $('<tr></tr>').css({
                    'text-align': 'center',
                    'font-weight': 'bold'
                });
                headerRow.append('<th style="border: 1px solid black;">Imagen</th>');
                headerRow.append('<th style="border: 1px solid black;">Nombre Completo</th>');
                headerRow.append('<th style="border: 1px solid black;">Tags</th>');
                headerRow.append('<th style="border: 1px solid black;">Código</th>');
                headerRow.append('<th style="border: 1px solid black;">Precio</th>');
                headerRow.append('<th style="border: 1px solid black;">Presentación</th>');
                headerRow.append(
                    '<th style="border: 1px solid black;">Empresa</th>'); // Added column header for Empresa
                newTable.append(headerRow);

                // Populate the new table with data from the original table
                $('.js-dataTable-responsive tbody tr').each(function() {
                    var newRow = $('<tr></tr>').css({
                        'text-align': 'center'
                    });

                    // Create an array of indices to include
                    var includeIndices = [1, 2, 3, 4, 5,
                        6, 7
                    ]; // Corresponding to: Imagen, Nombre, Código, Precio, Presentación, Empresa

                    $(this).find('td').each(function(index) {
                        // Only add the relevant columns (1 to 6, excluding the index and "Acciones")
                        if (includeIndices.includes(index)) {
                            var cellValue = $(this).html(); // Get the HTML content of the cell
                            var newCell = $('<td></td>').css({
                                'border': '1px solid black',
                                'padding': '10px', // Adjust padding as needed
                                'vertical-align': 'middle'
                            }).html(cellValue);
                            newRow.append(newCell);
                        }
                    });

                    newTable.append(newRow);
                });

                // Append new table to the body temporarily
                $('body').append(newTable);

                // Use html2canvas to capture the newly created table
                html2canvas(newTable[0], {
                    scale: 2
                }).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var pdf = new jsPDF('p', 'pt', 'a4'); // Change orientation to portrait
                    var imgWidth = pdf.internal.pageSize.getWidth() - 20; // Use full width minus margins
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;
                    var heightLeft = imgHeight;

                    var position = 10; // Start position with margin from the top

                    // Add image to PDF
                    pdf.addImage(imgData, 'PNG', 10, position, imgWidth,
                        imgHeight); // Start from the left corner
                    heightLeft -= pdf.internal.pageSize.getHeight();

                    // Add more pages if needed
                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        pdf.addPage();
                        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                        heightLeft -= pdf.internal.pageSize.getHeight();
                    }

                    // Save the PDF
                    pdf.save('Product_List.pdf');

                    // Remove the new table from the body
                    newTable.remove();
                }).catch(function(error) {
                    console.error("Error during html2canvas:", error);
                    // Clean up if an error occurs
                    newTable.remove();
                });
            }
        });
    </script>
@endsection
