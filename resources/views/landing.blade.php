@extends('layouts.simple')

@section('content')
    <!-- Hero -->

    <div class="hero bg-body-extra-light overflow-hidden">
        <div style="position: absolute; top: 2%; right: 1%;">
            <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                <i id="theme-icon" class="far fa-moon"></i>
                <span>Lightswitch</span>
            </a>
        </div>

        <div class="hero-inner">
            <div class="content content-full text-center">
                <p class="mb-2">
                    <i class="fas fa-fish fa-10x text-alert"></i>
                </p>

                <h1 class="fw-bold mb-2">
                    ISPI v<span class="text-city">0.1a</span>
                </h1>
                <p class="fs-lg fw-medium text-muted mb-4">
                    Parece que aún no has iniciado sesión, ingresa tus credenciales para acceder.
                </p>
                <button type="button" class="btn btn-primary push" data-bs-toggle="modal"
                    data-bs-target="#modal-block-vcenter">Iniciar Sesión</button>
                <br><br>
            </div>

            <div class="modal fade" id="modal-block-vcenter" tabindex="-1" role="dialog"
                aria-labelledby="modal-block-vcenter" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Ingresa a tu Cuenta</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <div class="content">
                                    <div class="row justify-content-center push">
                                        <!-- Sign In Block -->
                                        <div class="block-content">
                                            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-2">
                                                <div class="d-flex align-items-center">
                                                    <h1 class="h1 mb-1 me-2">ISPI</h1>
                                                    <span class="text-city"><i class="fas fa-fish fa-3x text-alert"></i>
                                                </div>
                                                <p class="fw-medium text-muted">
                                                    ¡Bienvenido!
                                                </p>
                                                <!-- Check for errors and display toast -->
                                                @if (Session::has('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        {{ Session::get('error') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <!-- Sign In Form -->
                                                <form action="/login" method="POST">
                                                    @csrf
                                                    <div class="py-3">
                                                        <div class="mb-4">
                                                            <input type="text"
                                                                class="form-control form-control-alt form-control-lg"
                                                                id="email_or_nick" name="email_or_nick"
                                                                placeholder="Nombre de Usuario/Email" required>
                                                        </div>
                                                        <div class="mb-4 position-relative">
                                                            <input type="password"
                                                                class="form-control form-control-alt form-control-lg"
                                                                id="password" name="password" placeholder="Contraseña"
                                                                required>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y"
                                                                id="togglePassword"
                                                                style="border:none; background:transparent;">
                                                                <i id="eyeIcon" class="fa fa-eye-slash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-12 col-xl-12">
                                                            <button type="submit" class="btn w-100  btn-alt-primary">
                                                                <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i>
                                                                Iniciar Sesión
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END Sign In Form -->

                                            </div>
                                        </div>
                                        <!-- END Sign In Block -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <!-- END Hero -->
    @if (Session::has('openModal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Show the modal when the page loads
                var myModal = new bootstrap.Modal(document.getElementById('modal-block-vcenter'), {
                    keyboard: false
                });
                myModal.show();
            });
        </script>
    @endif
    <script>
        document.getElementById('togglePassword').addEventListener('mousedown', function() {
            let passwordInput = document.getElementById('password');
            let eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('togglePassword').addEventListener('mouseup', function() {
            let passwordInput = document.getElementById('password');
            let eyeIcon = document.getElementById('eyeIcon');
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        });

        document.getElementById('togglePassword').addEventListener('mouseleave', function() {
            let passwordInput = document.getElementById('password');
            let eyeIcon = document.getElementById('eyeIcon');
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        });
    </script>
    <!-- CSS for modal animation, dark mode toggle, and smooth color transition -->
@endsection
