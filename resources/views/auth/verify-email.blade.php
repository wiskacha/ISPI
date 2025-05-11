@extends('layouts.simple')

@section('content')
    <div class="hero bg-body-extra-light overflow-hidden">

        <div style="position: absolute; top: 2%; right: 1%; display: flex; align-items: center;">
            <!-- Logout Button (Triggers Modal) -->
            <div class="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>

            <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)"
                style="margin-left: 10px;">
                <i id="theme-icon" class="far fa-moon"></i>
                <span>Interruptor</span>
            </a>
        </div>

        <div class="hero-inner">
            <div class="content content-full text-center">
                <p class="mb-0">
                    <i class="fa fa-fish-fins fa-10x text-alert"></i>
                </p>

                <div class="container d-flex flex-column justify-content-center align-items-center">
                    <h5 class="alert alert-info text-center" style="width: 100%; max-width: 400px;">
                        {{ __('Verifica tu dirección de correo electrónico') }}
                    </h5>

                    <div class="text-center" style="width: 100%; max-width: 400px;">
                        @if (Auth::check() && Auth::user()->persona)
                            <p>
                                {!! __('¡Hola, :name!', ['name' => '<strong>' . Auth::user()->nick . '</strong>']) !!}<br>
                                {{ __('Se enviará un correo electrónico de verificación a:') }}<br>
                                <strong>{{ Illuminate\Support\Str::mask(Auth::user()->email, '*', 1, strlen(Auth::user()->email) - strpos(Auth::user()->email, '@') - 1) }}</strong>
                            </p>
                        @else
                            <p>{{ __('Por favor, inicia sesión para recibir tu correo electrónico de verificación.') }}</p>
                        @endif

                        <div class="alert alert-info">
                            {{ __('Por favor, verifica tu dirección de correo electrónico antes de continuar.') }}
                        </div>

                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                            </div>
                        @endif

                        <!-- Resend Button -->
                        <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                            @csrf
                            <button type="submit" class="btn btn-primary" id="resend-button">
                                {{ __('Enviar correo de verificación') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">{{ __('Confirmación de Cerrar Sesión') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('¿Estás seguro de que deseas cerrar sesión?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ __('Cerrar sesión') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resend-form').addEventListener('submit', function(event) {
            var button = document.getElementById('resend-button');
            button.disabled = true;
            button.innerHTML = "{{ __('Enviando...') }}"; // Update button text while sending
        });
    </script>
@endsection
