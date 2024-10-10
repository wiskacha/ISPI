@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
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

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // <!--- Cambio de titulo item-main-menu -->
            const radioButtons = document.querySelectorAll('input[name="tipo"]');
            const TiponavLinkName = document.getElementById('TiponavLinkName');

            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    TiponavLinkName.innerHTML = 'Tipo: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
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

            tipoOP1.addEventListener('change', function() {
                if (tipoOP1.checked) {
                    // Mostrar el elemento cuando el radio está seleccionado
                    clienteNavItem.style.display = 'none';
                    recintoNavItem.style.display = 'none';
                    proveedorNavItem.style.display = 'none';

                    CliinputsInBlock.forEach(input => input.disabled = true);
                    RecinputsInBlock.forEach(input => input.disabled = true);

                    ProvinputsInBlock.forEach(input => input.disabled = true);

                }
            });
            tipoOP2.addEventListener('change', function() {
                if (tipoOP2.checked) {
                    // Mostrar el elemento cuando el radio está seleccionado
                    clienteNavItem.style.display = 'block'; // O 'flex', depende del diseño
                    recintoNavItem.style.display = 'block';
                    proveedorNavItem.style.display = 'none';

                    CliinputsInBlock.forEach(input => input.disabled = false);
                    RecinputsInBlock.forEach(input => input.disabled = false);

                    ProvinputsInBlock.forEach(input => input.disabled = true);
                }
            });
            tipoOP3.addEventListener('change', function() {
                if (tipoOP3.checked) {
                    // Mostrar el elemento cuando el radio está seleccionado
                    clienteNavItem.style.display = 'none';
                    recintoNavItem.style.display = 'none';
                    proveedorNavItem.style.display = 'block';

                    CliinputsInBlock.forEach(input => input.disabled = true);
                    RecinputsInBlock.forEach(input => input.disabled = true);

                    ProvinputsInBlock.forEach(input => input.disabled = false);
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
                    almacennavLinkName.innerHTML = 'Almacen: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            // Update the label when "Seleccionar Almacén" is selected
            AlmradioSelect.addEventListener('change', function() {
                if (AlmradioSelect.checked) {
                    almacenDropdown.disabled = false;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedAlmacen = almacenDropdown.options[almacenDropdown.selectedIndex].text;
                    almacennavLinkName.innerHTML = 'Almacen: ' + selectedAlmacen +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            // Update almacennavLinkName whenever the user changes the selected option in the dropdown
            almacenDropdown.addEventListener('change', function() {
                const selectedAlmacen = almacenDropdown.options[almacenDropdown.selectedIndex].text;
                almacennavLinkName.innerHTML = 'Almacen: ' + selectedAlmacen +
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
                    operadornavLinkName.innerHTML = 'Operador: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            OperadioSelect.addEventListener('change', function() {
                if (OperadioSelect.checked) {
                    operadorDropdown.disabled = false;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedOperador = operadorDropdown.options[operadorDropdown.selectedIndex].text;
                    const codigoOpe = selectedOperador.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    operadornavLinkName.innerHTML = 'Operador: CI[' + codigoOpe +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            operadorDropdown.addEventListener('change', function() {
                const selectedOperador = operadorDropdown.options[operadorDropdown.selectedIndex].text;
                const codigoOpe = selectedOperador.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                operadornavLinkName.innerHTML = 'Operador: CI[' + codigoOpe +
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

                    criterionavLinkName.innerHTML = 'Criterio: ' + this.value +
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

                    criterionavLinkName.innerHTML = 'Criterio: P[' + codigoP +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            productoDropdown.addEventListener('change', function() {
                const selectedProducto = productoDropdown.options[productoDropdown.selectedIndex].text;
                const codigoP = selectedProducto.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                criterionavLinkName.innerHTML = 'Criterio: P[' + codigoP +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });

            CriterioradioSelectE.addEventListener('change', function() {
                if (CriterioradioSelectE.checked) {
                    empresaDropdown.disabled = false;
                    productoDropdown.disabled = true;
                    // Set the almacennavLinkName to the currently selected almacén from the dropdown
                    const selectedEmpresa = empresaDropdown.options[empresaDropdown.selectedIndex].text;
                    criterionavLinkName.innerHTML = 'Criterio: ' + selectedEmpresa +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            empresaDropdown.addEventListener('change', function() {
                const selectedEmpresa = empresaDropdown.options[empresaDropdown.selectedIndex].text;
                criterionavLinkName.innerHTML = 'Criterio: E[' + selectedEmpresa +
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
                    clientenavLinkName.innerHTML = 'Cliente: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            CliradioSelect.addEventListener('change', function() {
                if (CliradioSelect.checked) {
                    clienteDropdown.disabled = false;
                    const selectedCliente = clienteDropdown.options[clienteDropdown.selectedIndex].text;
                    const codigoCli = selectedCliente.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    clientenavLinkName.innerHTML = 'Cliente: CI[' + codigoCli +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            clienteDropdown.addEventListener('change', function() {
                const selectedCliente = clienteDropdown.options[clienteDropdown.selectedIndex].text;
                const codigoCli = selectedCliente.match(/\[([a-zA-Z0-9]+)\]/)?.[1];
                clientenavLinkName.innerHTML = 'Cliente: CI[' + codigoCli +
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
                    recintonavLinkName.innerHTML = 'Recinto: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            RecradioSelect.addEventListener('change', function() {
                if (RecradioSelect.checked) {
                    recintoDropdown.disabled = false;
                    const selectedRecinto = recintoDropdown.options[recintoDropdown.selectedIndex].text;

                    recintonavLinkName.innerHTML = 'Recinto: ' + selectedRecinto +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            recintoDropdown.addEventListener('change', function() {
                const selectedRecinto = recintoDropdown.options[recintoDropdown.selectedIndex].text;

                recintonavLinkName.innerHTML = 'Recinto: ' + selectedRecinto +
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
                    proveedornavLinkName.innerHTML = 'Prov: ' + this.value +
                        ' <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            ProvradioSelect.addEventListener('change', function() {
                if (ProvradioSelect.checked) {
                    proveedorDropdown.disabled = false;
                    const selectedProveedor = proveedorDropdown.options[proveedorDropdown.selectedIndex]
                        .text;
                    const codigoProv = selectedProveedor.match(/\[([a-zA-Z0-9]+)\]/)?.[1];

                    proveedornavLinkName.innerHTML = 'Proveedor: CI[' + codigoProv +
                        '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
                }
            });

            proveedorDropdown.addEventListener('change', function() {
                const selectedProveedor = proveedorDropdown.options[proveedorDropdown.selectedIndex].text;
                const codigoProv = selectedProveedor.match(/\[([a-zA-Z0-9]+)\]/)?.[1];
                proveedornavLinkName.innerHTML = 'Proveedor: CI[' + codigoProv +
                    '] <i class="fa fa-check-circle text-success" title="Verified User"></i>';
            });
            // <!---- Fin de Opciones de Cliente -->:


            // ENVIO DE FORMULARIO
            const form = document.getElementById('reportForm');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Collect form data
                const formData = new FormData(form);
                formData.forEach((value, key) => {
                    console.log(key + ': ' + value);
                });
                // Send AJAX request
                fetch('/generate-report', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Handle success (e.g., show a success message, download the report)
                            console.log('Report generated successfully:', data.message);
                        } else {
                            // Handle errors
                            console.error('Error generating report:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
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
        <div class="block-content block-content-full">
            <form id="reportForm" action="/generate-report" method="POST">
                @csrf
                <div id="horizontal-navigation-click-normal-dark" class="d-lg-block mt-2">
                    <ul class="nav-main nav-main-horizontal nav-main">

                        <!-- Tipo -->
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-shuffle"></i>
                                <span id="TiponavLinkName" class="nav-main-link-name">Tipo: <small class="text-muted">no
                                        seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP1" name="tipo"
                                                    value="Existencias">
                                                <label class="form-check-label" for="tipoOP1">Existencias
                                                    <br>
                                                    <small>(entrada y salidas)</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP2" name="tipo"
                                                    value="Ventas">
                                                <label class="form-check-label" for="tipoOP2">Ventas
                                                    <br>
                                                    <small>(salidas)</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="tipoOP3" name="tipo"
                                                    value="Adquisiciones">
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
                        <li class="nav-main-item" id="almacen-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-warehouse"></i>
                                <span id="almacennavLinkName" class="nav-main-link-name">Almacen: <small
                                        class="text-muted">no
                                        seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="almacenTodos"
                                                    name="almacenOption" value="todos">
                                                <label class="form-check-label" for="almacenTodos">TODOS</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="almacenSelect"
                                                    name="almacenOption" value="specific">
                                                <label class="form-check-label" for="almacenSelect">Seleccionar
                                                    Almacén</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="almacenDropdown" disabled>
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
                        <li class="nav-main-item" id="operador-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-user-tie"></i>
                                <span id="operadornavLinkName" class="nav-main-link-name">Operador: <small
                                        class="text-muted">no seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="operadorTodos"
                                                    name="operadorOption" value="todos">
                                                <label class="form-check-label" for="operadorTodos">TODOS</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="operadorSelect"
                                                    name="operadorOption" value="specific">
                                                <label class="form-check-label" for="operadorSelect">Seleccionar
                                                    Operador</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="operadorDropdown" disabled>
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
                        <li class="nav-main-item" id="criterio-nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon si si-target"></i>
                                <span id="criterionavLinkName" class="nav-main-link-name">Criterio: <small
                                        class="text-muted">no seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="criterioTodos"
                                                    name="criterioOption" value="todos p.">
                                                <label class="form-check-label" for="criterioTodos">Todos los
                                                    Productos</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="criterioSelectP"
                                                    name="criterioOption" value="specificP">
                                                <label class="form-check-label" for="criterioSelectP">Selec.
                                                    Producto</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="productoDropdown" disabled>
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->id_producto }}">
                                                        [{{ $producto->codigo }}] {{ $producto->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="criterioSelectE"
                                                    name="criterioOption" value="specificE">
                                                <label class="form-check-label" for="criterioSelectE">Selec.
                                                    Empresa<span class="badge rounded-pill text-bg-danger">beta!</span>
                                                </label>
                                            </div>
                                            <select class="form-select" id="empresaDropdown" disabled>
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
                        <li class="nav-main-item" id="cliente-nav-main-item" style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-person"></i>
                                <span id="clientenavLinkName" class="nav-main-link-name">Cliente: <small
                                        class="text-muted">no seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
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
                                            <select class="form-select" id="clienteDropdown" disabled>
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
                        <li class="nav-main-item" id="recinto-nav-main-item" style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-location-dot"></i>
                                <span id="recintonavLinkName" class="nav-main-link-name">Recinto: <small
                                        class="text-muted">no seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
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
                                            <select class="form-select" id="recintoDropdown" disabled>
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
                        <li class="nav-main-item" id="proveedor-nav-main-item" style="display: none;">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-cart-shopping"></i>
                                <span id="proveedornavLinkName" class="nav-main-link-name">Proveedor: <small
                                        class="text-muted">no seleccionado</small></span>
                            </a>
                            <ul class="nav-main-submenu" style="border-radius: 0px; padding: 0;">
                                <div class="block" style="width: 100%; height: 100%;">
                                    <div class="block-content">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <!-- First radio option for 'TODOS' -->
                                                <input class="form-check-input" type="radio" id="proveedorTodos"
                                                    name="proveedorOption" value="todos">
                                                <label class="form-check-label" for="proveedorTodos">Todos los
                                                    Recintos</label>
                                            </div>

                                            <div class="form-check">
                                                <!-- Second radio option for enabling the select input -->
                                                <input class="form-check-input" type="radio" id="proveedorSelect"
                                                    name="proveedorOption" value="specific">
                                                <label class="form-check-label" for="proveedorSelect">Selec.
                                                    Proveedor</label>
                                            </div>

                                            <!-- The select input should be disabled by default -->
                                            <select class="form-select" id="proveedorDropdown" disabled>
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
                        <button id="generarReciboBtn" type="submit" class="btn btn-lg btn-alt-info">
                            <i class="fa fa-file-pdf"></i>
                            <span class="d-none d-sm-inline">Generar Informe</span>
                        </button>
                    </ul>
                </div>
            </form>
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


@endsection
