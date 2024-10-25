@extends('layouts.simple')

@section('content')
    <div class="hero-static d-flex align-items-center">
        <div class="content">
            <div class="row justify-content-center push">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="block block-rounded mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Restablecer Contraseña</h3>
                        </div>
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                @if ($user)
                                    <div class="mb-4 text-center">
                                        <h2><i class="fa fa-fish fa-2x" style="color: red;"></i></h2>
                                        <h3>Hola, {{ $user->nick }}</h3>
                                        <p class="text-muted">Correo Electrónico: {{ $user->email }}</p>
                                    </div>
                                @endif

                                <form method="POST" id="resetPasswordForm" action="{{ route('password.update') }}">

                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg password-field"
                                                id="password" name="password" placeholder="Nueva Contraseña" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg password-field"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirmar Contraseña" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye" id="passwordIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-4" id="passwordMismatch" style="display: none; color: red;">
                                        Las contraseñas no coinciden.
                                    </div>
                                    <div class="mb-4" id="passwordLength" style="display: none; color: red;">
                                        La contraseña debe tener al menos 8 caracteres.
                                    </div>
                                    <div class="mb-4" id="passwordNumber" style="display: none; color: red;">
                                        La contraseña debe contener al menos un número.
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 text-end">
                                            <button type="button" class="btn w-100 btn-alt-primary" id="submitBtn"
                                                data-bs-toggle="modal" data-bs-target="#confirmationModal" disabled>
                                                Restablecer Contraseña
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1"
                                    aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmationModalLabel">Confirmar
                                                    Restablecimiento</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Por favor confirma la nueva contraseña antes de proceder:</p>
                                                <label for="modalPassword" class="form-label">Nueva Contraseña</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="modalPassword" readonly>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="toggleModalPassword">
                                                        <i class="fas fa-eye" id="modalPasswordIcon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="confirmSubmit">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const submitBtn = document.getElementById('submitBtn');
            const passwordMismatchMessage = document.getElementById('passwordMismatch');
            const passwordLengthMessage = document.getElementById('passwordLength');
            const passwordNumberMessage = document.getElementById('passwordNumber');
            const togglePassword = document.getElementById('togglePassword');
            const passwordFields = document.querySelectorAll('.password-field');
            const modalPasswordInput = document.getElementById('modalPassword');
            const toggleModalPassword = document.getElementById('toggleModalPassword');

            const validatePasswords = () => {
                const password = passwordInput.value;
                const passwordConfirmation = passwordConfirmationInput.value;

                const isValidLength = password.length >= 8;
                const hasNumber = /\d/.test(password);
                const passwordsMatch = password === passwordConfirmation;

                if (!isValidLength) {
                    passwordLengthMessage.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                } else {
                    passwordLengthMessage.style.display = 'none';
                    passwordInput.classList.remove('is-invalid');
                }

                if (!hasNumber) {
                    passwordNumberMessage.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                } else {
                    passwordNumberMessage.style.display = 'none';
                    passwordInput.classList.remove('is-invalid');
                }

                if (!passwordsMatch) {
                    passwordMismatchMessage.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                    passwordConfirmationInput.classList.add('is-invalid');
                    submitBtn.disabled = true;
                } else {
                    passwordMismatchMessage.style.display = 'none';
                    passwordInput.classList.remove('is-invalid');
                    passwordConfirmationInput.classList.remove('is-invalid');
                    passwordInput.classList.add('is-valid');
                    passwordConfirmationInput.classList.add('is-valid');
                }

                submitBtn.disabled = !(isValidLength && hasNumber && passwordsMatch);
            };

            passwordInput.addEventListener('input', validatePasswords);
            passwordConfirmationInput.addEventListener('input', validatePasswords);

            // Nuevo manejador para mostrar/ocultar ambas contraseñas
            togglePassword.addEventListener('mousedown', function() {
                passwordFields.forEach(field => field.type = 'text');
            });

            togglePassword.addEventListener('mouseup', function() {
                passwordFields.forEach(field => field.type = 'password');
            });

            // Prevenir que se queden visibles al perder el foco
            togglePassword.addEventListener('mouseleave', function() {
                passwordFields.forEach(field => field.type = 'password');
            });

            submitBtn.addEventListener('click', function() {
                modalPasswordInput.value = passwordInput.value;
                modalPasswordInput.type = 'password';
            });

            // Manejador para el botón del modal
            toggleModalPassword.addEventListener('mousedown', function() {
                modalPasswordInput.type = 'text';
            });

            toggleModalPassword.addEventListener('mouseup', function() {
                modalPasswordInput.type = 'password';
            });

            toggleModalPassword.addEventListener('mouseleave', function() {
                modalPasswordInput.type = 'password';
            });

            submitBtn.addEventListener('click', function() {
                modalPasswordInput.value = passwordInput.value;
                modalPasswordInput.type = 'password';
            });

            // Cambia el evento del botón del modal para enviar el formulario
            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('resetPasswordForm').submit();
            });

        });
    </script>
@endsection
