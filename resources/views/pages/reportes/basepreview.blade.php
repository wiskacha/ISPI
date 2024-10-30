@extends('layouts.backend')

@section('css')
    <style>
        @media (max-width: 1328px) {
            .hide-on-small {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .fa-2x-md {
                font-size: 1em;
            }
        }

        @media (min-width: 768px) {
            .fa-2x-md {
                font-size: 2em;
            }
        }

        .fs-7 {
            font-size: 0.9rem;
        }

        /* Change all Font Awesome icons to white when the dark-mode class is active */
        #page-container.dark-mode .fas {
            color: white;
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle the collapse for the detalles rows
            $('.clickable-row').click(function() {
                const target = $(this).data('target');
                $(target).collapse('toggle');
            });
            // Button to expand/collapse all desglose items
            $('#toggle-all').click(function() {
                const allDesglose = $('.desglose');
                if (allDesglose.is(':visible')) {
                    allDesglose.collapse('hide');
                } else {
                    allDesglose.collapse('show');
                }
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
                        ¡Instancia de Reporte Generada!
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
                            Reporte generado
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Reporte
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="flex-grow-1 text-centered">
                <h1 class="h3 fw-bold mb-1">
                    Criterios
                    <small class="fs-base lh-base fw-medium text-muted mb-0">
                        Estos fueron los criterios utilizados al momento de generar este lobby
                    </small>
                </h1>
            </div>
            <div class="criterios-busqueda">
                <div class="row g-2">
                    <!-- Tipo -->
                    <div class="col-12 col-sm-8 col-md-3 col-lg-3 col-xl">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-list-alt fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Tipo</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ $criteriosB->tipo ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Almacén -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-warehouse fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Almacén</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ $criteriosB->almacen ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operador -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-user-tie fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Operador</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ $criteriosB->operador ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Recinto -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-school-flag fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Recinto</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ $criteriosB->recinto ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proveedor -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-parachute-box fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Proveedor</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ $criteriosB->proveedor ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Producto / Empresa -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-box-open fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">Criterio</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ isset($criteriosB->producto) ? $criteriosB->producto : $criteriosB->empresa ?? 'No asignado' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-calendar-days fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="card-title mb-0 fs-7">{{ $criteriosB->criterio_fecha }}</h6>
                                    <p class="card-text small text-muted mb-0 text-truncate">
                                        {{ isset($criteriosB->desde) ? $criteriosB->desde : 'No asignado' }}
                                        {{ isset($criteriosB->hasta) ? ' - ' . $criteriosB->hasta : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="table-responsive">
                @yield('resumen')
            </div>

            <hr>
            <div class="demostracion-docs my-2">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="block block-rounded block-themed border">
                            <div class="block-header bg-danger">
                                <h3 class="block-title">
                                    <i class="fas fa-basket-shopping"></i>
                                    Deglose por Producto
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="d-flex justify-content-center align-items-center ">
                                    <div>
                                        <form action="{{ route('reportes.imprimirDesglosePorProducto') }}" method="POST"
                                            target="_blank">
                                            @csrf
                                            <div class="space-y-2">
                                                <input type="hidden" name="movimiento_ids"
                                                    value="{{ json_encode($movimientos->pluck('id_movimiento')) }}">
                                                <input type="hidden" name="criteriosB"
                                                    value="{{ json_encode($criteriosB) }}">

                                                <div class="d-flex justify-content-center align-items-center w-100">
                                                    <div class="flex-grow-1 mx-1">
                                                        <button type="submit" class="btn btn-alt-danger w-100"
                                                            name="action" value="pdf">
                                                            <i class="fa fa-file-pdf"></i>
                                                            <span class="hide-on-small">Visualizar PDF</span>
                                                        </button>
                                                    </div>
                                                    <div class="flex-grow-1 mx-1">
                                                        <button type="submit" class="btn btn-alt-success w-100"
                                                            name="action" value="download">
                                                            <i class="fa fa-download"></i>
                                                            <span class="hide-on-small">Descargar PDF</span>
                                                        </button>
                                                    </div>
                                                    <div class="flex-grow-1 mx-1">
                                                        <button type="submit" class="btn btn-alt-warning w-100"
                                                            name="action" value="preview">
                                                            <i class="fab fa-html5"></i>
                                                            <span class="hide-on-small">Previ. HTML</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center align-items-center w-100">
                                                    <br>                                                
                                                </div>
                                                <br>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-xl-6">
                        <div class="block block-rounded block-themed border">
                            <div class="block-header bg-smooth-modern">
                                <h3 class="block-title">
                                    <i class="far fa-file-pdf"></i>
                                    Desglose de Movimientos
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="{{ route('reportes.imprimirDesglose') }}" method="POST"
                                        target="_blank">
                                        @csrf
                                        <div class="space-y-2">
                                            <input type="hidden" name="movimiento_ids"
                                                value="{{ json_encode($movimientos->pluck('id_movimiento')) }}">
                                            <input type="hidden" name="criteriosB"
                                                value="{{ json_encode($criteriosB) }}">

                                            <div class="d-flex justify-content-center align-items-center w-100">
                                                <div class="flex-grow-1 mx-1">
                                                    <button type="submit" class="btn btn-alt-danger w-100"
                                                        name="action" value="pdf">
                                                        <i class="fa fa-file-pdf"></i>
                                                        <span class="hide-on-small">Visualizar PDF</span>
                                                    </button>
                                                </div>
                                                <div class="flex-grow-1 mx-1">
                                                    <button type="submit" class="btn btn-alt-success w-100"
                                                        name="action" value="download">
                                                        <i class="fa fa-download"></i>
                                                        <span class="hide-on-small">Descargar PDF</span>
                                                    </button>
                                                </div>
                                                <div class="flex-grow-1 mx-1">
                                                    <button type="submit" class="btn btn-alt-warning w-100"
                                                        name="action" value="preview">
                                                        <i class="fab fa-html5"></i>
                                                        <span class="hide-on-small">Previ. HTML</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center w-100">
                                                <span><strong>Sin</strong> Cuotas |</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cn_cuotas" name="cn_cuotas">
                                                    <label class="form-check-label" for="cn_cuotas"></label>
                                                </div>
                                                <span>| <strong>Con</strong> Cuotas</span>
                                            </div>
                                            <br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
