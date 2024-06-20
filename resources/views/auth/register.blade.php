@extends('layouts.simple')

@section('content')
<div class="hero-static d-flex align-items-center">
    <div class="w-100">
        <!-- Sign Up Section -->
        <div class="bg-body-extra-light">
            <div class="content content-full">
                <div class="text-left mt-3 ml-3">
                    <a href="/" class="btn btn-danger">
                        Regresar
                    </a>
                </div>
                <div class="row g-0 justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                        <!-- Header -->
                        <div class="text-center">
                            <p class="mb-2">
                                <i class="fas fa-fish fa-2x text-primary"></i>
                            </p>

                            <h1 class="h4 mb-1">
                                Registra tu cuenta
                            </h1>
                            <p class="text-muted mb-3">
                                Implementación de Sistema Proyectado a Inventariado
                            </p>
                        </div>
                        <!-- END Header -->

                        <!-- Form -->
                        <form action="/register" method="POST" class="js-validation-signup">
                            @csrf

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="nombre" name="nombre" placeholder="Nombres" required>
                            </div>

                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="papellido" name="papellido" placeholder="Primer Apellido" required>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var nombreInput = document.getElementById("nombre");
                                    var papellidoInput = document.getElementById("papellido");

                                    // Function to validate input against regex
                                    function validateInput(inputElement) {
                                        var inputValue = inputElement.value.trim(); // Trim whitespace

                                        // Regex to allow letters and spaces only, not at start or end
                                        var regex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/;
                                        if (!regex.test(inputValue)) {
                                            inputElement.value = "";
                                        }
                                    }
                                    nombreInput.addEventListener("input", function() {
                                        validateInput(this);
                                    });

                                    papellidoInput.addEventListener("input", function() {
                                        validateInput(this);
                                    });
                                });
                            </script>
                            <div class="mb-4">
                                <input type="number" class="form-control form-control-lg form-control-alt" id="carnet" name="carnet" placeholder="Cédula de Identidad" required min="1000000" max="9999999">
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var inputElement = document.getElementById("carnet");

                                    inputElement.addEventListener("input", function() {
                                        if (this.value.length > 7) {
                                            this.value = this.value.slice(0, 7); // Limit to 7 characters
                                        }
                                    });
                                });
                            </script>

                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="email" name="email" placeholder="Correo" required>
                            </div>

                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="nick" name="nick" placeholder="Usuario" required>
                            </div>

                            <div class="mb-4">
                                <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="Contraseña" required>
                            </div>

                            <div class="mb-4">
                                <input type="password" class="form-control form-control-lg form-control-alt" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary text-dark">
                                    Registrar
                                </button>
                            </div>

                        </form>
                        <!-- END Form -->
                        <div class="text-center mt-3 ml-3">
                            <a href="/login" class="text-primary">
                                ¿Ya estás registrado? Ingresa a tu cuenta
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Example of a dark mode toggle button -->
                <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                    <i class="far fa-moon"></i>
                </a>

            </div>
        </div>
        <!-- END Sign Up Section -->

        <!-- Additional Links -->
        <!-- END Additional Links -->
    </div>
</div>
@endsection