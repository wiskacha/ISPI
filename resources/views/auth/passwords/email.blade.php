@extends('layouts.simple') <!-- Asegúrate de tener un layout simple para la vista -->

@section('content')
    <div class="hero-static d-flex align-items-center">
        <div class="content">
            <div class="row justify-content-center push">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="block block-rounded mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Recuperar Contraseña</h3>
                            <div class="block-options">
                                <a class="btn-block-option" href="{{ route('login') }}" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title="Iniciar Sesión">
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                                <p class="fw-medium text-muted">
                                    Ingresa tu correo electrónico para enviar el enlace de restablecimiento.
                                </p>

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf <!-- Protección CSRF -->
                                    <div class="mb-4">
                                        <input type="email" class="form-control form-control-lg form-control-alt"
                                            id="email" name="email" placeholder="Correo Electrónico" required>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6 col-xl-5">
                                            <button type="submit" class="btn w-100 btn-alt-primary">
                                                <i class="fa fa-fw fa-envelope me-1 opacity-50"></i> Enviar
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Mostrar mensajes de estado o errores -->
                                    @if (session('status'))
                                        <div class="alert alert-success">{{ session('status') }}</div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fs-sm text-muted text-center">
            </div>
        </div>
    </div>


    <script>
        document.getElementById('password-reset-form').addEventListener('submit', function() {
            var button = this.querySelector('button[type="submit"]');
            button.disabled = true; // Desactiva el botón para prevenir múltiples envíos
            button.innerHTML = "{{ __('Enviando...') }}"; // Cambia el texto del botón
        });
    </script>
@endsection
