@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.css">
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

        /* Hide default buttons */
        #wizard .actions {
            display: none;
        }

        /* Hide dots if still visible */
        #wizard .steps ul li:before {
            display: none !important;
        }

        /* Hide default tabs if necessary */
        #wizard .steps {
            display: none;
        }

        /* Style custom tabs */
        #custom-tabs .nav-tabs {
            margin-bottom: 20px;
        }

        #custom-tabs .nav-link {
            cursor: pointer;
        }

        #custom-tabs .nav-link.active {
            font-weight: bold;
        }
    </style>
@endsection


@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Registro de Persona y Usuario</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Nuevo registro</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item" aria-current="page">Registro de Usuario nuevo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>
    <div class="content-container">
        <form id="registerForm" action="{{ route('personas.usuarios.register') }}" method="POST"
            class="js-validation-signup">
            @csrf
            <div id="wizard">


                <!-- Step 1: Persona Registration -->
                <h3 style="display:none;">Registrar Persona</h3> <!-- Keep this for jQuery Steps, but hide it -->
                <div id="custom-tabs" class="text-center mb-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#step-1">Registro de persona</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">Registro de usuario</a>
                        </li>
                    </ul>
                </div>
                <section>
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Registrar Persona</h3>
                        </div>
                        <div class="block-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Required Inputs -->
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="nombre" name="nombre" placeholder="Nombre"
                                                value="{{ old('nombre') }}" required>
                                            <label for="nombre">Nombre</label>
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="papellido" name="papellido" placeholder="Primer Apellido"
                                                value="{{ old('papellido') }}" required>
                                            <label for="papellido">Primer Apellido</label>
                                            @error('papellido')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="carnet" name="carnet" placeholder="Carnet"
                                                value="{{ old('carnet') }}" required>
                                            <label for="carnet">Carnet</label>
                                            @error('carnet')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Optional Inputs -->
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="sapellido" name="sapellido" placeholder="Segundo Apellido"
                                                value="{{ old('sapellido') }}">
                                            <label for="sapellido">Segundo Apellido (Opcional)</label>
                                            @error('sapellido')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="celular" name="celular" placeholder="Celular"
                                                value="{{ old('celular') }}">
                                            <label for="celular">Celular (Opcional)</label>
                                            @error('celular')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Step 2: User Registration -->
                <h3 style="display:none;">Registrar Usuario</h3> <!-- Keep this for jQuery Steps, but hide it -->
                <section>
                    <div class="block block-rounded mt-4">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Registrar Usuario</h3>
                        </div>
                        <div class="block-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="nick" name="nick" placeholder="Nick"
                                                value="{{ old('nick') }}">
                                            <label for="nick">Nick</label>
                                            @error('nick')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <input type="email" class="form-control form-control-lg form-control-alt"
                                                id="email" name="email" placeholder="Correo Electrónico"
                                                value="{{ old('email') }}">
                                            <label for="email">Correo Electrónico</label>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control form-control-lg form-control-alt"
                                                id="password" name="password" placeholder="Contraseña">
                                            <label for="password">Contraseña</label>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control form-control-lg form-control-alt"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirmar Contraseña">
                                            <label for="password_confirmation">Confirmar Contraseña</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div id="custom-buttons" class="text-center">
                    <div class="btn-group" role="group">
                        <button id="custom-prev" class="btn btn-secondary">Anterior</button>
                        <button id="custom-next" class="btn btn-primary">Siguiente</button>
                        <button id="custom-finish" class="btn btn-success" style="display: none;">Registrar
                            Usuario</button>
                    </div>
                </div>
        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#wizard").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                enableAllSteps: true,
                autoFocus: true,
                onFinished: function(event, currentIndex) {
                    $("#registerForm").submit(); // Submit the form on finish
                },
                labels: {
                    finish: "Registrar Usuario",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                onInit: function(event, currentIndex) {
                    customizeWizardButtons();
                    updateCustomTabs(currentIndex);
                },
                onStepChanged: function(event, currentIndex, priorIndex) {
                    customizeWizardButtons();
                    updateCustomTabs(currentIndex);
                }
            });

            // Function to customize the wizard buttons with Bootstrap classes
            function customizeWizardButtons() {
                let prevBtn = $('#custom-prev');
                let nextBtn = $('#custom-next');
                let finishBtn = $('#custom-finish');

                prevBtn.addClass('btn btn-secondary'); // Style 'Anterior' as secondary
                nextBtn.addClass('btn btn-primary'); // Style 'Siguiente' as primary
                finishBtn.addClass('btn btn-success'); // Style 'Registrar Usuario' as primary

                let currentIndex = $("#wizard").steps("getCurrentIndex");
                let totalSteps = $("#wizard").find('.steps ul li').length;

                if (currentIndex === 0) {
                    prevBtn.prop('disabled', true); // Disable 'Anterior' on first step
                } else {
                    prevBtn.prop('disabled', false); // Enable 'Anterior' otherwise
                }

                if (currentIndex === totalSteps - 1) {
                    nextBtn.hide(); // Hide 'Siguiente' on the last step
                    finishBtn.show(); // Show 'Registrar Usuario' on the last step
                } else {
                    nextBtn.show(); // Show 'Siguiente' otherwise
                    finishBtn.hide(); // Hide 'Registrar Usuario' otherwise
                }
            }

            // Function to update custom tabs based on the current step
            function updateCustomTabs(currentIndex) {
                $("#custom-tabs .nav-link").removeClass('active');
                $("#custom-tabs .nav-link").eq(currentIndex).addClass('active');
            }

            // Bind custom button click events
            $('#custom-prev').on('click', function() {
                $("#wizard").steps("previous"); // Go to previous step
            });

            $('#custom-next').on('click', function() {
                $("#wizard").steps("next"); // Go to next step
            });

            $('#custom-finish').on('click', function() {
                $("#wizard").steps("finish"); // Complete the wizard
            });

            // Handle click events on custom tabs
            $("#custom-tabs .nav-link").on('click', function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                let target = $(this).attr('href'); // Get href of clicked tab
                let stepIndex = $("#wizard").find('section').index($(target)); // Get the step index
                $("#wizard").steps('setStep', stepIndex); // Set the step index
            });
        });
    </script>
@endsection
