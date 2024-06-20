@extends('layouts.simple')

@section('content')
<div class="hero-static d-flex align-items-center">
    <div class="content">
        <div class="row justify-content-center push">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <!-- Sign In Block -->
                <div class="block block-rounded mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ingresa a tu Cuenta</h3>
                    </div>
                    <div class="block-content">
                        <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                            <h1 class="h2 mb-1">ISPI &#9811; </h1>
                            <p class="fw-medium text-muted">
                                ¡Bienvenido!
                            </p>

                            <!-- Check for errors and display toast -->
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Sign In Form -->
                            <form action="/login" method="POST">
                                @csrf
                                <div class="py-3">
                                    <div class="mb-4">
                                        <input type="text" class="form-control form-control-alt form-control-lg" id="nick" name="nick" placeholder="Nombre de Usuario/Email" required>
                                    </div>

                                    <div class="mb-4">
                                        <input type="password" class="form-control form-control-alt form-control-lg" id="password" name="password" placeholder="Contraseña" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12 col-xl-12">
                                        <button type="submit" class="btn w-100  btn-alt-primary">
                                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Iniciar Sesión
                                        </button>
                                    </div>
                                </div>
                                <div class="fw-medium text-muted text-center mt-4">
                                    <a href="/register" class="text-primary">¿No tienes cuenta? ¡Registráte!</a>
                                    <br><br>
                                </div>
                            </form>
                            <!-- END Sign In Form -->
                        </div>
                        <!-- Example of a dark mode toggle button -->
                        <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                            <i class="far fa-moon"></i>
                        </a>

                    </div>
                </div>
                <!-- END Sign In Block -->

                <!-- Additional Links -->

                <div class="text-center mt-3">
                    <a href="/" class="btn btn-danger w-100">Regresar</a>
                </div>
                <!-- END Additional Links -->
            </div>
        </div>
    </div>
</div>
@endsection
