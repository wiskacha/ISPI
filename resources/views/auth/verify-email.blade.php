<!-- resources/views/auth/verify-email.blade.php -->

@extends('layouts.simple')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <h5 class="alert alert-info text-center" style="width: 100%; max-width: 400px;">
            {{ __('Verifica tu dirección de correo electrónico') }}
        </h5>

        <div class="text-center" style="width: 100%; max-width: 400px;">
            @if (Auth::check() && Auth::user()->persona)
                @php
                    /** @var User $user */
                @endphp
                <p>
                    {{ __('¡Hola, :name!', ['name' => Auth::user()->nick]) }}<br>
                    {{ __('Se enviará un correo electrónico de verificación a:') }}<br>
                    <strong>{{ Str::mask(Auth::user()->email, '*', 1, strlen(Auth::user()->email) - strpos(Auth::user()->email, '@') - 1) }}</strong>
                </p>
            @else
                <p>
                    {{ __('¡Hola, Invitado!') }}<br>
                    {{ __('Por favor, inicia sesión para recibir tu correo electrónico de verificación.') }}
                </p>
            @endif

            <div class="alert alert-info">
                {{ __('Por favor, verifica tu dirección de correo electrónico antes de continuar.') }}
            </div>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">{{ __('Reenviar correo de verificación') }}</button>
            </form>

            <!-- Logout Button -->
            <form method="GET" action="{{ route('logout') }}" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="btn btn-danger">{{ __('Cerrar sesión') }}</button>
            </form>
        </div>
    </div>
@endsection
