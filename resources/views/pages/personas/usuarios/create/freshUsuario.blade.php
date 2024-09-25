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

        .form-group {
            margin-bottom: 15px;
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
                        <li class="breadcrumb-item active" aria-current="page">Registro de Usuario nuevo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
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
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="nombre" name="nombre" placeholder="Nombre"
                                                value="{{ old('nombre') }}" required>
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="papellido">Primer Apellido</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="papellido" name="papellido" placeholder="Primer Apellido"
                                                value="{{ old('papellido') }}" required>
                                            @error('papellido')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="carnet">Carnet</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="carnet" name="carnet" placeholder="Carnet"
                                                value="{{ old('carnet') }}" required>
                                            @error('carnet')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Optional Inputs -->
                                        <div class="form-group">
                                            <label for="sapellido">Segundo Apellido (Opcional)</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="sapellido" name="sapellido" placeholder="Segundo Apellido"
                                                value="{{ old('sapellido') }}">
                                            @error('sapellido')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="celular">Celular (Opcional)</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="celular" name="celular" placeholder="Celular"
                                                value="{{ old('celular') }}">
                                            @error('celular')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
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
                                        <div class="form-group">
                                            <label for="nick">Nick</label>
                                            <input type="text" class="form-control form-control-lg form-control-alt"
                                                id="nick" name="nick" placeholder="Nick"
                                                value="{{ old('nick') }}">
                                            @error('nick')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Correo Electrónico</label>
                                            <input type="email" class="form-control form-control-lg form-control-alt"
                                                id="email" name="email" placeholder="Correo Electrónico"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <input type="password" class="form-control form-control-lg form-control-alt"
                                                id="password" name="password" placeholder="Contraseña">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Contraseña</label>
                                            <input type="password" class="form-control form-control-lg form-control-alt"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirmar Contraseña">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>

        <div id="custom-buttons" class="text-center">
            <div class="btn-group" role="group">
                <button id="custom-prev" class="btn btn-secondary">Anterior</button>
                <button id="custom-next" class="btn btn-primary">Siguiente</button>
                <button id="custom-finish" class="btn btn-success" style="display: none;">Registrar
                    Usuario</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
    <script>
        $(document).ready(function() {
            // Custom regex validation for names, etc.
            $.validator.addMethod("regex", function(value, element, regexpr) {
                return regexpr.test(value);
            });

            // Initialize form validation
            $("#registerForm").validate({
                rules: {
                    // Persona fields
                    nombre: {
                        required: true,
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                        maxlength: 100
                    },
                    papellido: {
                        required: true,
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                        maxlength: 100
                    },
                    sapellido: {
                        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?:\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/,
                        maxlength: 100
                    },
                    carnet: {
                        required: true,
                        regex: /^\d{4,11}$/,
                        maxlength: 100
                    },
                    celular: {
                        regex: /^\d{8,11}$/
                    },
                    // User fields
                    nick: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    // Persona messages
                    nombre: {
                        required: "El nombre es requerido.",
                        regex: "El nombre solo puede contener letras y espacios.",
                        maxlength: "El nombre no puede tener más de 100 caracteres."
                    },
                    papellido: {
                        required: "El primer apellido es requerido.",
                        regex: "Solo puede contener letras y espacios.",
                        maxlength: "El primer apellido no puede tener más de 100 caracteres."
                    },
                    sapellido: {
                        regex: "Solo puede contener letras y espacios."
                    },
                    carnet: {
                        required: "El carnet es requerido.",
                        regex: "El carnet debe contener entre 4 y 11 dígitos.",
                        maxlength: "El carnet no puede tener más de 100 caracteres."
                    },
                    celular: {
                        regex: "El celular debe contener entre 8 y 11 dígitos."
                    },
                    // User messages
                    nick: {
                        required: "El nick es requerido.",
                        maxlength: "El nick no puede tener más de 255 caracteres."
                    },
                    email: {
                        required: "El correo electrónico es requerido.",
                        email: "Por favor ingrese un correo electrónico válido.",
                        maxlength: "El correo electrónico no puede tener más de 255 caracteres."
                    },
                    password: {
                        required: "La contraseña es requerida.",
                        minlength: "La contraseña debe tener al menos 8 caracteres."
                    },
                    password_confirmation: {
                        required: "Por favor confirme su contraseña.",
                        equalTo: "Las contraseñas no coinciden."
                    }
                },
                onkeyup: function(element) {
                    $(element).valid(); // Trigger validation
                    toggleButtons(); // Check button states
                },
                onfocusout: function(element) {
                    $(element).valid(); // Trigger validation
                    toggleButtons(); // Check button states
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    if (element.val() === "" && (element.attr('name') === "sapellido" || element.attr(
                            'name') === "celular")) {
                        // Remove errors if the field is empty
                        error.remove();
                    } else if (element.is(":focus")) {
                        // Show errors for currently focused element
                        error.insertAfter(element);
                    } else {
                        // Initially hide errors and only show after interaction
                        error.hide();
                    }
                },
                showErrors: function(errorMap, errorList) {
                    // Show errors only after user interaction
                    $.each(this.errorList, function(index, error) {
                        $(error.element).data('previous-error', error.message);
                    });
                    this.defaultShowErrors();

                    // Manage specific case for empty fields
                    $("#registerForm").find(":input").each(function() {
                        var name = $(this).attr("name");
                        if ((name === "sapellido" || name === "celular") && $(this).val() ===
                            "") {
                            $(this).removeData('previous-error');
                            $(this).next('label.error')
                                .remove(); // Remove any existing error message
                        }
                    });
                }
            });

            // Toggle buttons based on validation
            function toggleButtons() {
                var isValid = true;
                $("#registerForm").find(":input").each(function() {
                    var name = $(this).attr("name");
                    if (name !== "sapellido" && name !== "celular") {
                        if (!$("#registerForm").validate().element($(this))) {
                            isValid = false;
                        }
                    } else {
                        if ($(this).val() !== "" && !$("#registerForm").validate().element($(this))) {
                            isValid = false;
                        }
                    }
                });

                $("#custom-next").prop('disabled', !isValid);
                $("#custom-finish").prop('disabled', !isValid);
            }

            // Handle the next, prev, and finish button logic
            var currentStep = 1;
            var totalSteps = 2;

            $("#custom-next").click(function() {
                if (currentStep < totalSteps) {
                    var isValid = true;
                    $("#registerForm").find(":input").each(function() {
                        var name = $(this).attr("name");
                        if (name !== "sapellido" && name !== "celular") {
                            if (!$("#registerForm").validate().element($(this))) {
                                isValid = false;
                            }
                        }
                    });
                    if (isValid) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });

            $("#custom-prev").click(function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // This should always allow going to the previous step
            $("#custom-prev").prop('disabled', currentStep === 1);

            $("#custom-finish").click(function() {
                if ($("#registerForm").valid()) {
                    $("#registerForm").submit();
                }
            });

            $("#registerForm").on('submit', function() {
                var email = $("#email").val();
                var nick = $("#nick").val();

                if (email) {
                    $("#email").val(email.toLowerCase());
                }
                if (nick) {
                    $("#nick").val(nick.toLowerCase());
                }
            });
            // Show specific step
            function showStep(step) {
                // Update the active tab
                $(".nav-link").removeClass('active');
                $(".nav-link[href='#step-" + step + "']").addClass('active');

                // Show the current step and hide others
                $("section").hide();
                $("section:nth-of-type(" + step + ")").show();

                // Show or hide the finish button based on the step
                if (step === totalSteps) {
                    $("#custom-finish").show();
                    $("#custom-next").hide();
                } else {
                    $("#custom-finish").hide();
                    $("#custom-next").show();
                }

                // Update previous button state
                $("#custom-prev").prop('disabled', step === 1);

                // Ensure 'Siguiente' button is enabled if the current step is valid
                if (step === 1) {
                    // Check if step 1 is valid
                    $("#custom-next").prop('disabled', !$("#registerForm").validate().element("#nombre") ||
                        !$("#registerForm").validate().element("#papellido") ||
                        !$("#registerForm").validate().element("#carnet"));
                } else if (step === 2) {
                    // Check if step 2 is valid
                    $("#custom-next").prop('disabled', !$("#registerForm").valid());
                }
            }

            // Initialize steps visibility
            showStep(currentStep);

            // Disable next button initially
            toggleButtons();
        });
    </script>
@endsection
