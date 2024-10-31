@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
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
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- DataTables Core -->
    <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>

    <!-- DataTables Bootstrap 5 integration -->
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Other DataTables plugins -->
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Other libraries -->
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- Your custom scripts -->
    @vite(['resources/js/pages/datatables.js'])


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.form-select').select2();
            // <!--- Cambio de titulo item-main-menu -->
            const radioButtons = document.querySelectorAll('input[name="tipo"]');
            const TiponavLinkName = document.getElementById('TiponavLinkName');

            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    TiponavLinkName.innerHTML = 'Tipo: </br>' + this.value +
                        '<i class="fa fa-check-circle text-success" title="Verified User"></i>';
                });
            });

            const tipoOP1 = document.getElementById('tipoOP1');
            const tipoOP2 = document.getElementById('tipoOP2');
            const tipoOP3 = document.getElementById('tipoOP3');
            const clienteNavItem = document.getElementById('cliente-nav-main-item');
            const recintoNavItem = document.getElementById('recinto-nav-main-item');
            const proveedorNavItem = document.getElementById('proveedor-nav-main-item');

            const CliinputsInBlock = clienteNavItem.querySelectorAll('input, select, textarea, button');
            const RecinputsInBlock = recintoNavItem.querySelectorAll('input, select, textarea, button');
            const ProvinputsInBlock = proveedorNavItem.querySelectorAll('input, select, textarea, button');

            // Función para habilitar/deshabilitar inputs y gestionar el atributo required
            function toggleInputs(inputs, enable) {
                inputs.forEach(input => {
                    input.disabled = !enable; // Deshabilita o habilita el campo
                    if (enable) {
                        input.setAttribute('required', 'required'); // Añade required si está habilitado
                    } else {
                        input.removeAttribute('required'); // Quita required si está deshabilitado
                    }
                });
            }

            // Listener para tipoOP1 (oculta los elementos)
            tipoOP1.addEventListener('change', function() {
                if (tipoOP1.checked) {
                    clienteNavItem.style.display = 'none';
                    recintoNavItem.style.display = 'none';
                    proveedorNavItem.style.display = 'none';

                    toggleInputs(CliinputsInBlock, false); // Deshabilitar y quitar required
                    toggleInputs(RecinputsInBlock, false);
                    toggleInputs(ProvinputsInBlock, false);
                }
            });

            // Listener para tipoOP2 (muestra cliente y recinto, oculta proveedor)
            tipoOP2.addEventListener('change', function() {
                if (tipoOP2.checked) {
                    clienteNavItem.style.display = 'block'; // Mostrar
                    recintoNavItem.style.display = 'block';
                    proveedorNavItem.style.display = 'none'; // Ocultar

                    toggleInputs(CliinputsInBlock, true); // Habilitar y añadir required
                    toggleInputs(RecinputsInBlock, true);
                    toggleInputs(ProvinputsInBlock, false); // Deshabilitar proveedor
                }
            });

            // Listener para tipoOP3 (muestra proveedor, oculta cliente y recinto)
            tipoOP3.addEventListener('change', function() {
                if (tipoOP3.checked) {
                    clienteNavItem.style.display = 'none';
                    recintoNavItem.style.display = 'none';
                    proveedorNavItem.style.display = 'block'; // Mostrar

                    toggleInputs(CliinputsInBlock, false); // Deshabilitar cliente
                    toggleInputs(RecinputsInBlock, false); // Deshabilitar recinto
                    toggleInputs(ProvinputsInBlock, true); // Habilitar proveedor
                }
            });
            // <!--- Fin de Cambio de titulo item-main-menu -->:

            // <!---- Opciones de almacen -->
            const AlmradioTodos = document.getElementById('almacenTodos');
            const AlmradioSelect = document.getElementById('almacenSelect');
            const almacenDropdown = document.getElementById('almacenDropdown');
            const almacennavLinkName = document.getElementById('almacennavLinkName');

            // Update the label when "TODOS" is selected
            AlmradioTodos.addEventListener('change', function() {
                if (AlmradioTodos.checked) {
                    almacenDropdown.disabled = true;
                    almacennavLinkName.innerHTML = 'Almacen: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            // Update the label when "Seleccionar Almacén" is selected
            AlmradioSelect.addEventListener('change', function() {
                if (AlmradioSelect.checked) {
                    almacenDropdown.disabled = false;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedAlmacen = almacenDropdown.options[almacenDropdown.selectedIndex].text;
                    almacennavLinkName.innerHTML = 'Almacen: </br>' + selectedAlmacen +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            // Update almacennavLinkName whenever the user changes the selected option in the dropdown
            almacenDropdown.addEventListener('change', function() {
                const selectedAlmacen = almacenDropdown.options[almacenDropdown.selectedIndex].text;
                almacennavLinkName.innerHTML = 'Almacen: </br>' + selectedAlmacen +
                    ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de almacen -->:


            // <!---- Opciones de Operador -->
            const OperadioTodos = document.getElementById('operadorTodos');
            const OperadioSelect = document.getElementById('operadorSelect');
            const operadorDropdown = document.getElementById('operadorDropdown');
            const operadornavLinkName = document.getElementById('operadornavLinkName');

            OperadioTodos.addEventListener('change', function() {
                if (OperadioTodos.checked) {
                    operadorDropdown.disabled = true;
                    operadornavLinkName.innerHTML = 'Operador: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            OperadioSelect.addEventListener('change', function() {
                if (OperadioSelect.checked) {
                    operadorDropdown.disabled = false;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedOperador = operadorDropdown.options[operadorDropdown.selectedIndex].text;
                    const codigoOpe = selectedOperador.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    operadornavLinkName.innerHTML = 'Operador: </br>CI[' + codigoOpe +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            operadorDropdown.addEventListener('change', function() {
                const selectedOperador = operadorDropdown.options[operadorDropdown.selectedIndex].text;
                const codigoOpe = selectedOperador.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                operadornavLinkName.innerHTML = 'Operador: </br>CI[' + codigoOpe +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de operador -->:

            // <!---- Opciones de Criterio -->
            const CriterioradioTodos = document.getElementById('criterioTodos');
            const CriterioradioSelectP = document.getElementById('criterioSelectP');
            const CriterioradioSelectE = document.getElementById('criterioSelectE');

            const productoDropdown = document.getElementById('productoDropdown');
            const empresaDropdown = document.getElementById('empresaDropdown');

            const criterionavLinkName = document.getElementById('criterionavLinkName');

            CriterioradioTodos.addEventListener('change', function() {
                if (CriterioradioTodos.checked) {
                    productoDropdown.disabled = true;
                    empresaDropdown.disabled = true;

                    criterionavLinkName.innerHTML = 'Criterio: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            CriterioradioSelectP.addEventListener('change', function() {
                if (CriterioradioSelectP.checked) {
                    productoDropdown.disabled = false;
                    empresaDropdown.disabled = true;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedProducto = productoDropdown.options[productoDropdown.selectedIndex].text;
                    const codigoP = selectedProducto.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    criterionavLinkName.innerHTML = 'Criterio: </br>P[' + codigoP +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            productoDropdown.addEventListener('change', function() {
                const selectedProducto = productoDropdown.options[productoDropdown.selectedIndex].text;
                const codigoP = selectedProducto.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                criterionavLinkName.innerHTML = 'Criterio: </br>P[' + codigoP +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });

            CriterioradioSelectE.addEventListener('change', function() {
                if (CriterioradioSelectE.checked) {
                    empresaDropdown.disabled = false;
                    productoDropdown.disabled = true;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedEmpresa = empresaDropdown.options[empresaDropdown.selectedIndex].text;
                    criterionavLinkName.innerHTML = 'Criterio: </br>E[' + selectedEmpresa +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            empresaDropdown.addEventListener('change', function() {
                const selectedEmpresa = empresaDropdown.options[empresaDropdown.selectedIndex].text;
                criterionavLinkName.innerHTML = 'Criterio: </br>E[' + selectedEmpresa +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de Criterio -->:

            // <!---- Opciones de Cliente -->
            const CliradioTodos = document.getElementById('clienteTodos');
            const CliradioSelect = document.getElementById('clienteSelect');
            const clienteDropdown = document.getElementById('clienteDropdown');
            const clientenavLinkName = document.getElementById('clientenavLinkName');

            CliradioTodos.addEventListener('change', function() {
                if (CliradioTodos.checked) {
                    clienteDropdown.disabled = true;
                    clientenavLinkName.innerHTML = 'Cliente: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            CliradioSelect.addEventListener('change', function() {
                if (CliradioSelect.checked) {
                    clienteDropdown.disabled = false;
                    const selectedCliente = clienteDropdown.options[clienteDropdown.selectedIndex].text;
                    const codigoCli = selectedCliente.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    clientenavLinkName.innerHTML = 'Cliente: </br>CI[' + codigoCli +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            clienteDropdown.addEventListener('change', function() {
                const selectedCliente = clienteDropdown.options[clienteDropdown.selectedIndex].text;
                const codigoCli = selectedCliente.match(/\[([a-zA-Z0-9]+)\]/)?.[1];
                clientenavLinkName.innerHTML = 'Cliente: </br>CI[' + codigoCli +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de Cliente -->:

            // <!---- Opciones de Recinto -->
            const RecradioTodos = document.getElementById('recintoTodos');
            const RecradioSelect = document.getElementById('recintoSelect');
            const recintoDropdown = document.getElementById('recintoDropdown');
            const recintonavLinkName = document.getElementById('recintonavLinkName');

            RecradioTodos.addEventListener('change', function() {
                if (RecradioTodos.checked) {
                    recintoDropdown.disabled = true;
                    recintonavLinkName.innerHTML = 'Recinto: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            RecradioSelect.addEventListener('change', function() {
                if (RecradioSelect.checked) {
                    recintoDropdown.disabled = false;
                    const selectedRecinto = recintoDropdown.options[recintoDropdown.selectedIndex].text;

                    recintonavLinkName.innerHTML = 'Recinto: </br>' + selectedRecinto +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            recintoDropdown.addEventListener('change', function() {
                const selectedRecinto = recintoDropdown.options[recintoDropdown.selectedIndex].text;

                recintonavLinkName.innerHTML = 'Recinto: </br>' + selectedRecinto +
                    ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de Recinto -->:

            // <!---- Opciones de Prooveedor -->
            const ProvradioTodos = document.getElementById('proveedorTodos');
            const ProvradioSelect = document.getElementById('proveedorSelect');
            const proveedorDropdown = document.getElementById('proveedorDropdown');
            const proveedornavLinkName = document.getElementById('proveedornavLinkName');

            ProvradioTodos.addEventListener('change', function() {
                if (ProvradioTodos.checked) {
                    proveedorDropdown.disabled = true;
                    proveedornavLinkName.innerHTML = 'Proveedor: </br>' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            ProvradioSelect.addEventListener('change', function() {
                if (ProvradioSelect.checked) {
                    proveedorDropdown.disabled = false;
                    const selectedProveedor = proveedorDropdown.options[proveedorDropdown.selectedIndex]
                        .text;
                    const codigoProv = selectedProveedor.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    proveedornavLinkName.innerHTML = 'Proveedor: </br>CI[' + codigoProv +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            proveedorDropdown.addEventListener('change', function() {
                const selectedProveedor = proveedorDropdown.options[proveedorDropdown.selectedIndex].text;
                const codigoProv = selectedProveedor.match(/\[([a-zA-Z0-9]+)\]/)?.[1];
                proveedornavLinkName.innerHTML = 'Proveedor: </br>CI[' + codigoProv +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de Prooveedor -->:


            // <!---- Opciones de Prooveedor -->
            // Get references to the relevant DOM elements
            const FecradioCreac = document.getElementById('fechaCreac');
            const FecradioFinal = document.getElementById('fechaFinal');
            const fechaDesde = document.getElementById('example-daterange1');
            const fechaHasta = document.getElementById('example-daterange2');
            const fechasnavLinkName = document.getElementById('fechasnavLinkName');

            // Function to update fechasnavLinkName
            function updateFechasNavLinkName() {
                let selectedOption = '';

                if (FecradioCreac.checked) {
                    selectedOption = 'Creación';
                } else if (FecradioFinal.checked) {
                    selectedOption = 'Finalización';
                }

                fechasnavLinkName.innerHTML = 'Fecha ' + selectedOption +
                    ':</br>desde [' + fechaDesde.value + '] hasta [' + fechaHasta.value + '] ' +
                    '<i class="fa fa-check-circle text-success" title="Verified User"></i>';
            }

            // Add event listeners to the radio buttons
            FecradioCreac.addEventListener('change', updateFechasNavLinkName);
            FecradioFinal.addEventListener('change', updateFechasNavLinkName);

            // Add event listeners to the date inputs to dynamically update when dates are changed
            fechaDesde.addEventListener('input', updateFechasNavLinkName);
            fechaHasta.addEventListener('input', updateFechasNavLinkName);
            // <!---- Fin de Opciones de Prooveedor -->:

            // ENVIO DE FORMULARIO
            // const form = document.getElementById('reportForm');

            // form.addEventListener('submit', function(event) {
            //     event.preventDefault();

            //     // Collect form data
            //     const formData = new FormData(form);
            //     formData.forEach((value, key) => {
            //         console.log(key + ': ' + value);
            //     });
            //     // Send AJAX request
            //     fetch('/generate-report', {
            //             method: 'POST',
            //             body: formData,
            //             headers: {
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            //                     .getAttribute('content')
            //             }
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 // Handle success (e.g., show a success message, download the report)
            //                 console.log('Report generated successfully:', data.message);
            //             } else {
            //                 // Handle errors
            //                 console.error('Error generating report:', data.message);
            //             }
            //         })
            //         .catch(error => {
            //             console.error('Error:', error);
            //         });
            // });

            //FECHAS!!!!
            // Function to convert date from dd/mm/yyyy to yyyy-mm-dd
            function convertToMySQLDate(dateStr) {
                var parts = dateStr.split("/");
                return parts[2] + "-" + parts[1] + "-" + parts[0];
            }

            // Function to convert date from yyyy-mm-dd to dd/mm/yyyy
            function convertToDisplayDate(dateStr) {
                var parts = dateStr.split("-");
                return parts[2] + "/" + parts[1] + "/" + parts[0];
            }

            // Initialize datepickers
            var $desdeDate = jQuery('#example-daterange1');
            var $hastaDate = jQuery('#example-daterange2');
            var $desdeMysql = jQuery('#desde_mysql');
            var $hastaMysql = jQuery('#hasta_mysql');

            $desdeDate.datepicker({
                weekStart: 1,
                autoclose: true,
                todayHighlight: true,
                language: 'es',
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(selected) {
                var startDate = new Date(selected.date.valueOf());
                $hastaDate.datepicker('setStartDate', startDate);
                $desdeMysql.val(convertToMySQLDate($desdeDate.val()));
                updateFechasNavLinkName(); // Update the fechasnavLinkName when date is selected
            });

            $hastaDate.datepicker({
                weekStart: 1,
                autoclose: true,
                todayHighlight: true,
                language: 'es',
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(selected) {
                var endDate = new Date(selected.date.valueOf());
                $desdeDate.datepicker('setEndDate', endDate);
                $hastaMysql.val(convertToMySQLDate($hastaDate.val()));
                updateFechasNavLinkName(); // Update the fechasnavLinkName when date is selected

            });

            // Handle manual input
            $desdeDate.on('change', function() {
                $desdeMysql.val(convertToMySQLDate($desdeDate.val()));
                updateFechasNavLinkName(); // Update the fechasnavLinkName when date is selected

            });

            $hastaDate.on('change', function() {
                $hastaMysql.val(convertToMySQLDate($hastaDate.val()));
                updateFechasNavLinkName(); // Update the fechasnavLinkName when date is selected

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
                        Vista de Reportes
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Generar (Reportes)
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Reportes</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Vista de Reportes
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Generación de Reporte
            </h3>
        </div>
        <form id="reportForm" action="{{ route('reportes.reportegenerado') }}" target="_blank" method="POST">
            @csrf
            <div class="block-content block-content-full">

                <div id="horizontal-navigation-click-normal-dark g-2" class="d-lg-block mt-2">
                    <ul class="nav-main nav-main-horizontal nav-main">

                        <!-- Tipo -->
                        <li class="nav-main-item col-12 col-lg-5 col-xl-2">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-shuffle"></i>
                                <span id="TiponavLinkName" class="nav-main-link-name">
                                    Tipo:
                                    <small class="text-muted">
                                        </br>
                                        No selecc.
                                    </small>
                                </span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP1" name="tipo"
                                                    value="Existencias" required>
                                                <label class="form-check-label" for="tipoOP1">Existencias
                                                    <br>
                                                    <small>(entrada y salidas)</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP2" name="tipo"
                                                    value="Ventas" required>
                                                <label class="form-check-label" for="tipoOP2">Ventas
                                                    <br>
                                                    <small>(salidas)</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP3" name="tipo"
                                                    value="Adquisiciones" required>
                                                <label class="form-check-label" for="tipoOP3">Adquisiciones
                                                    <br>
                                                    <small>(entradas)</small>
                                                </label>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Almacen -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="almacen-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-warehouse"></i>
                                <span id="almacennavLinkName" class="nav-main-link-name">
                                    Almacen:
                                    <small class="text-muted">
                                        </br>No seleccionado
                                    </small>
                                </span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="almacenTodos"
                                                    name="almacenOption" value="todos" required>
                                                <label class="form-check-label" for="almacenTodos">TODOS</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="almacenSelect"
                                                    name="almacenOption" value="specific" required>
                                                <label class="form-check-label" for="almacenSelect">Seleccionar
                                                    Almacén</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" name="almacen" id="almacenDropdown" required
                                                disabled>
                                                @foreach ($almacenes as $almacene)
                                                    <option value="{{ $almacene->id_almacen }}">
                                                        {{ $almacene->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Operador -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="operador-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-user-tie"></i>
                                <span id="operadornavLinkName" class="nav-main-link-name">Operador: <small
                                        class="text-muted"></br>No seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="operadorTodos"
                                                    name="operadorOption" value="todos" required>
                                                <label class="form-check-label" for="operadorTodos">TODOS</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="operadorSelect"
                                                    name="operadorOption" value="specific" required>
                                                <label class="form-check-label" for="operadorSelect">Seleccionar
                                                    Operador</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="operadorDropdown" name="operador" required
                                                disabled>
                                                @foreach ($operadores as $operador)
                                                    <option value="{{ $operador->id_persona }}">
                                                        [{{ $operador->carnet }}] {{ $operador->papellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Criterio -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="criterio-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon si si-target"></i>
                                <span id="criterionavLinkName" class="nav-main-link-name">Criterio: <small
                                        class="text-muted"></br>No seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="criterioTodos"
                                                    name="criterioOption" value="todos p." required>
                                                <label class="form-check-label" for="criterioTodos">Todos los
                                                    Productos</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="criterioSelectP"
                                                    name="criterioOption" value="specificP" required>
                                                <label class="form-check-label" for="criterioSelectP">Selec.
                                                    Producto</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="productoDropdown" name="producto" required
                                                disabled>
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->id_producto }}">
                                                        [{{ $producto->codigo }}] {{ $producto->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="criterioSelectE"
                                                    name="criterioOption" value="specificE" required>
                                                <label class="form-check-label" for="criterioSelectE">Selec.
                                                    Empresa<span class="badge rounded-pill text-bg-danger">beta!</span>
                                                </label>
                                            </div>
                                            <select class="form-select" id="empresaDropdown" name="empresa" required
                                                disabled>
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Cliente -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="cliente-nav-main-item"
                            style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-person"></i>
                                <span id="clientenavLinkName" class="nav-main-link-name">Cliente: <small
                                        class="text-muted"></br>No seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="clienteTodos"
                                                    name="clienteOption" value="todos">
                                                <label class="form-check-label" for="clienteTodos">Todos los
                                                    Clientes</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="clienteSelect"
                                                    name="clienteOption" value="specific">
                                                <label class="form-check-label" for="clienteSelect">Selec.
                                                    Cliente</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="clienteDropdown" name="cliente" disabled>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id_persona }}">
                                                        [{{ $cliente->carnet }}] {{ $cliente->papellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Recinto -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="recinto-nav-main-item"
                            style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-location-dot"></i>
                                <span id="recintonavLinkName" class="nav-main-link-name">Recinto: <small
                                        class="text-muted"></br>No seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="recintoTodos"
                                                    name="recintoOption" value="todos">
                                                <label class="form-check-label" for="recintoTodos">Todos los
                                                    Recintos</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="recintoSelect"
                                                    name="recintoOption" value="specific">
                                                <label class="form-check-label" for="recintoSelect">Selec.
                                                    Recinto</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="recintoDropdown" name="recinto" disabled>
                                                @foreach ($recintos as $recinto)
                                                    <option value="{{ $recinto->id_recinto }}">
                                                        {{ $recinto->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <!-- Proveedor -->
                        <li class="nav-main-item col-12  col-lg-5 col-xl-3" id="proveedor-nav-main-item"
                            style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-cart-shopping"></i>
                                <span id="proveedornavLinkName" class="nav-main-link-name">Proveedor: <small
                                        class="text-muted"></br>No seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="proveedorTodos"
                                                    name="proveedorOption" value="todos">
                                                <label class="form-check-label" for="proveedorTodos">Todos los
                                                    Proveedores</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="proveedorSelect"
                                                    name="proveedorOption" value="specific">
                                                <label class="form-check-label" for="proveedorSelect">Selec.
                                                    Proveedor</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="proveedorDropdown" name="proveedor" disabled>
                                                @foreach ($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->id_persona }}">
                                                        [{{ $proveedor->carnet }}] {{ $proveedor->papellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <br>
                        <!-- Fechas NEW -->
                        <li class="nav-main-item col-12 col-sm-12 col-lg-6 col-xl-5" id="fechas-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu border" data-toggle="submenu"
                                aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon si si-calendar"></i>
                                <span id="fechasnavLinkName" class="nav-main-link-name">Fecha: <small
                                        class="text-muted"></br>No seleccionada</small></span>
                            </a>
                            <ul class="nav-main-submenu w-100" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="fechaCreac"
                                                    name="fechaOption" value="create" required>
                                                <label class="form-check-label" for="fechaOption">Creación</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="fechaFinal"
                                                    name="fechaOption" value="final" required>
                                                <label class="form-check-label" for="fechaOption">Finalización</label>
                                            </div>
                                            <!-- The select input should be disabled by default -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="example-daterange1"
                                                            style="margin-top: 1rem;">Desde</label>
                                                        <input type="text" class="js-datepicker form-control"
                                                            id="example-daterange1" placeholder="dd/mm/yyyy" autocomplete="off" required>
                                                        <input type="hidden" name="desde" id="desde_mysql" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="example-daterange2"
                                                            style="margin-top: 1rem;">Hasta</label>
                                                        <input type="text" class="js-datepicker form-control"
                                                            id="example-daterange2" placeholder="dd/mm/yyyy" autocomplete="off" required>
                                                        <input type="hidden" name="hasta" id="hasta_mysql" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <br />
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
                <hr>
                <div class="row">
                    <div class="ms-auto d-flex justify-content-end">
                        <button id="generarReciboBtn" type="submit"
                            class="col-12 col-md-6 col-lg-4 col-xl-3-2 btn btn-lg btn-alt-info">
                            <i class="fa fa-file-pdf"></i>
                            <span class="d-sm-inline">Generar Informe</span>
                        </button>
                    </div>
                </div>
        </form>
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


@endsection
