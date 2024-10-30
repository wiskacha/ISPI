@php
    Log::info('Errors in view: ' . json_encode(session('errors')));
    Log::info('Old input: ' . json_encode(old()));
@endphp

@extends('layouts.backend')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 900px) {
            .hide-on-small {
                display: none;
            }
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

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Asignación de Contacto a Persona</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Nuevo registro</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Contactos</li>
                        <li class="breadcrumb-item active" aria-current="page">Asignación de Contacto</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <br>
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default" style="margin-bottom: 1rem;">
                        <h3 class="block-title">{{ __('Registrar Usuario') }}</h3>
                    </div>
                    <div class="container">
                        @if ($errors->any())
                            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
                                <div id="errorToast" class="toast show" role="alert" aria-live="assertive"
                                    aria-atomic="true">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="me-auto">Error</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                                            aria-label="Close"></button>
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

                        <form action="{{ route('contactos.registerE') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="id_empresa" style="margin-bottom: 1rem;">Empresa</label>
                                        <select class="js-example-basic-single form-control form-control-lg" id="id_empresa"
                                            name="id_empresa" required>
                                            <option value="" disabled selected>Selecciona una empresa</option>
                                            @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_empresa')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="id_persona" style="margin-bottom: 1rem;">Persona</label>
                                        <select class="js-example-basic-single form-control form-control-lg" id="id_persona"
                                            name="id_persona" required>
                                            <option value="" disabled selected>Selecciona una persona</option>
                                            @foreach ($personas as $persona)
                                                <option value="{{ $persona->id_persona }}">
                                                    [{{ $persona->carnet }}] {{ substr($persona->nombre, 0, 2) . '.' }}
                                                    {{ $persona->papellido }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_persona')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 ms-auto d-flex justify-content-end">
                                <a href="{{ route('contactos.vistaContactos') }}" class="btn btn-secondary me-2"
                                    style="margin-bottom: 1rem;">Cancelar</a>
                                <button type="submit" class="btn btn-alt-primary"
                                    style="margin-bottom: 1rem;">Registrar</button>
                            </div>

                        </form>
                    </div>

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
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
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
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Select2 for the empresa and persona select fields
            $('#id_empresa').select2({
                placeholder: "Selecciona una empresa",
                allowClear: false,
            });
            $('#id_persona').select2({
                placeholder: "Selecciona una persona",
                allowClear: false,
            });
        });
    </script>
@endsection
