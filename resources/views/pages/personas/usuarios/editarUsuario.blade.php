@extends('layouts.backend')

@section('content')
    <!-- Modal Structure -->
    @include('partials.confirmation-modalU', ['user' => $user])

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Editar Usuario
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            Usuarios
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Editar Usuario
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="block block-rounded m-2">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Editar Usuario
            </h3>
        </div>
        <div class="container mt-4">
            <div class="">
                <div class="card-body">
                    <form id="update-form" action="{{ route('personas.updateUsuario', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nick" class="form-label">Nombre</label>
                                <input type="text" id="nick" name="nick" value="{{ old('nick', $user->nick) }}"
                                    class="form-control" required>
                                <span id="nick-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control" required>
                                <span id="email-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <span id="password-error" class="text-danger"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                <input type="password" id="password-confirm" name="password_confirmation"
                                    class="form-control">
                                <span id="password-confirm-error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 align-items-center">
                            <!-- Botón de deshacer -->
                            <button type="reset" id="reset-btn" class="btn btn-warning me-2">Deshacer</button>

                            <div class="d-flex align-items-center">
                                <!-- Texto "No se han realizado cambios" -->
                                <span id="no-changes-text" class="text-muted font-italic me-3" style="white-space: nowrap;">
                                    No se han realizado cambios
                                </span>

                                <!-- Ícono para pantallas pequeñas -->
                                <i id="no-changes-icon" class="fas fa-lock text-muted me-3" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="No se han realizado cambios" style="display: none;"></i>
                                <!-- Botón de actualizar -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" id="update-btn" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal">Actualizar</button>
                                    <a href="{{ route('personas.usuarios.vistaUsuarios') }}" class="btn btn-secondary"
                                        id="cancelar-btn">Cancelar</a>
                                </div>
                            </div>
                        </div>

                    </form>

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

    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // DOM Elements
            const fields = {
                nick: document.getElementById("nick"),
                email: document.getElementById("email"),
                password: document.getElementById("password"),
                passwordConfirm: document.getElementById("password-confirm")
            };
            const updateBtn = document.getElementById("update-btn");
            const noChangesText = document.getElementById("no-changes-text");
            const noChangesIcon = document.getElementById("no-changes-icon");

            // Original values for comparison
            const originals = {
                nick: "{{ $user->nick }}",
                email: "{{ $user->email }}",
                password: "",
                passwordConfirm: ""
            };

            // Track touched fields and debounce timers
            let touchedFields = new Set();
            let debounceTimeouts = {};
            let lastValidValues = {
                ...originals
            }; // Store last valid values

            /* ------------- Utility Functions ------------- */

            // Debounce function to prevent excessive API requests
            function debounce(func, delay) {
                return function(...args) {
                    const key = args[0].id;
                    if (debounceTimeouts[key]) {
                        clearTimeout(debounceTimeouts[key]);
                    }
                    debounceTimeouts[key] = setTimeout(() => func(...args), delay);
                };
            }

            // Set the validity state and error message for an input
            function setInputValidity(input, isValid, formatMsg = '', existsMsg = '') {
                const errorSpan = document.getElementById(`${input.id}-error`);
                if (isValid) {
                    input.classList.remove("is-invalid");
                    input.classList.add("is-valid");
                    errorSpan.textContent = '';
                } else {
                    input.classList.remove("is-valid");
                    input.classList.add("is-invalid");
                    errorSpan.textContent = existsMsg || formatMsg;
                }
            }

            // Reset the state of an input field
            function resetFieldState(input) {
                input.classList.remove("is-valid", "is-invalid");
                const errorSpan = document.getElementById(`${input.id}-error`);
                if (errorSpan) errorSpan.textContent = '';
            }

            // Validate all touched fields to enable or disable the update button
            function validateAllFields() {
                const allValid = Array.from(touchedFields).every(id => {
                    const input = fields[id];
                    const errorSpan = document.getElementById(`${id}-error`);
                    return input.classList.contains("is-valid") || errorSpan.textContent === '';
                });
                updateBtn.disabled = !allValid;
                noChangesText.style.display = allValid ? 'none' : 'inline';
                noChangesIcon.style.display = allValid ? 'none' : 'inline';
            }

            /* ------------- Field Validation Functions ------------- */

            // Validate 'nick' field by checking with API
            function validateNickInput(input) {
                const value = input.value.trim().toLowerCase(); // Convert to lowercase for comparison

                // Bypass validation if the value matches the original (case-insensitive)
                if (value === originals.nick.toLowerCase()) {
                    resetFieldState(input);
                    setInputValidity(input, true); // Treat as valid
                    touchedFields.delete(input.id);
                    return;
                }

                fetch(`/validate-nick?value=${encodeURIComponent(value)}`)
                    .then(response => response.json())
                    .then(data => {
                        lastValidValues.nick = value;
                        setInputValidity(input, !data.exists, '', "Este nick ya está registrado.");
                        validateAllFields();
                    });
            }

            // Validate 'email' field by checking with API
            function validateEmailInput(input) {
                const value = input.value.trim().toLowerCase(); // Convert to lowercase for comparison

                // Bypass validation if the value matches the original (case-insensitive)
                if (value === originals.email.toLowerCase()) {
                    resetFieldState(input);
                    setInputValidity(input, true); // Treat as valid
                    touchedFields.delete(input.id);
                    return;
                }

                fetch(`/validate-email?value=${encodeURIComponent(value)}`)
                    .then(response => response.json())
                    .then(data => {
                        lastValidValues.email = value;
                        setInputValidity(input, !data.exists, '',
                        "Este correo electrónico ya está registrado.");
                        validateAllFields();
                    });
            }

            // Validate 'password' field for length
            function validatePasswordInput(input) {
                const value = input.value.trim();
                if (!value) {
                    resetFieldState(input);
                    return;
                }
                const minLength = 8;
                const isValid = value.length >= minLength;
                setInputValidity(input, isValid, `La contraseña debe tener al menos ${minLength} caracteres.`);
                if (isValid && fields.passwordConfirm.value) {
                    validatePasswordConfirmation(fields.passwordConfirm);
                }
            }

            // Validate 'password_confirm' field for matching password
            function validatePasswordConfirmation(input) {
                const value = input.value.trim();
                const passwordValue = fields.password.value.trim();
                const isValid = value === passwordValue;
                setInputValidity(input, isValid, 'Las contraseñas no coinciden.');
            }

            /* ------------- Event Listeners ------------- */

            // Add event listeners to input fields with debounce
            fields.nick.addEventListener('input', debounce(() => {
                touchedFields.add('nick');
                validateNickInput(fields.nick);
            }, 100));

            fields.email.addEventListener('input', debounce(() => {
                touchedFields.add('email');
                validateEmailInput(fields.email);
            }, 100));

            fields.password.addEventListener('input', debounce(() => {
                touchedFields.add('password');
                validatePasswordInput(fields.password);
            }, 100));

            fields.passwordConfirm.addEventListener('input', debounce(() => {
                touchedFields.add('passwordConfirm');
                validatePasswordConfirmation(fields.passwordConfirm);
            }, 100));

            // Prevent form submission if fields are invalid
            document.getElementById("update-form").addEventListener("submit", function(event) {
                if (updateBtn.disabled) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
