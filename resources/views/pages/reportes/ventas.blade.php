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
    <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Reporte
            </h3>
        </div>
        <div class="block-content block-content-full">
            {{-- <div class="criterios-busqueda">
                <span><strong>Almacén:</strong> {{ $criteriosB->almacen ?? 'No asignado' }}</span>
                <span><strong>Operador:</strong> {{ $criteriosB->operador ?? 'No asignado' }}</span>
                <span><strong>Producto:</strong> {{ $criteriosB->producto ?? 'No asignado' }}</span>
                <span><strong>Empresa:</strong> {{ $criteriosB->empresa ?? 'No asignado' }}</span>
                <span><strong>Desde:</strong> {{ $criteriosB->desde ?? 'No asignado' }}</span>
                <span><strong>Hasta:</strong> {{ $criteriosB->hasta ?? 'No asignado' }}</span>
                <span><strong>Tipo:</strong> {{ $criteriosB->tipo ?? 'No asignado' }}</span>
                <span><strong>Recinto:</strong> {{ $criteriosB->recinto ?? 'No asignado' }}</span>
                <span><strong>Proveedor:</strong> {{ $criteriosB->proveedor ?? 'No asignado' }}</span>
            </div> --}}
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
                                <i class="fas fa-building fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
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
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-calendar-day fa-fw fa-lg fa-2x-md me-2 me-md-3"></i>
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




            <div class="block block-rounded" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
                <div class="block-header block-header-default clickable-row" data-target="#contenido-tabla"
                    style="cursor: pointer;">
                    <h3 class="block-title">
                        DESGLOSE DE MOVIMIENTOS
                    </h3>
                </div>
                <div id="contenido-tabla" class="block-content block-content-full collapse">
                    <div class="ms-3">
                        <form action="{{ route('reportes.imprimirDesglose') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="movimiento_ids"
                                value="{{ json_encode($movimientos->pluck('id_movimiento')) }}">
                            <input type="hidden" name="criteriosB" value="{{ json_encode($criteriosB) }}">

                            <!-- Pass only the IDs of movimientos -->
                            <button type="submit" class="btn btn-primary">Generar PDF</button>
                        </form>
                    </div>

                    <div class="ms-auto d-flex justify-content-end">
                        <button id="toggle-all" class="btn btn-alt-warning">
                            Expandir / Colapsar Todos
                        </button>
                    </div>
                    <hr />
                    <!-- Check if there are any movimientos to display -->
                </div>
            </div>
        </div>
    </div>
@endsection
