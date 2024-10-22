@component('mail::message')
{{-- Header con una imagen --}}
@slot('header')
    <img src="{{ asset('images/header-logo.png') }}" alt="Logo" style="width: 100px;"/>
@endslot

{{-- Título personalizado con el nombre del usuario --}}
{{ __('¡Hola, :name!', ['name' => $userName]) }}

{{ __('Por favor, haz clic en el botón a continuación para verificar tu dirección de correo electrónico.') }}

@component('mail::button', ['url' => $url])
    {{ __('Verificar Correo Electrónico') }}
@endcomponent

{{ __('Si no creaste una cuenta, no es necesario realizar ninguna otra acción.') }}

{{ __('Si tienes problemas para hacer clic en el botón de "Verificar Correo Electrónico", copia y pega la siguiente URL en tu navegador web:') }}<br>
{{ $url }}

{{ __('Saludos,') }}<br>
{{ config('app.name') }}
@endcomponent