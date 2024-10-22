@extends('layouts.simple')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center bg-dark" style="min-height: 100vh;">
        <h5 class="alert alert-info text-center" style="width: 100%; max-width: 400px;">
            {{ __('Verifica tu dirección de correo electrónico') }}
        </h5>

        <div class="text-center" style="width: 100%; max-width: 400px;">
            @if (Auth::check() && Auth::user()->persona)
                <p>
                    {{ __('¡Hola, :name!', ['name' => Auth::user()->nick]) }}<br>
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
                {{-- @php
                    dd(session()->all());
                @endphp --}}
            @endif

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                @csrf
                <button type="submit" class="btn btn-primary" id="resend-button">
                    {{ __('Reenviar correo de verificación') }}
                </button>
            </form>

            <!-- Logout Button -->
            <form method="GET" action="{{ route('logout') }}" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="btn btn-danger">{{ __('Cerrar sesión') }}</button>
            </form>
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
