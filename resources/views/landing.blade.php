@extends('layouts.simple')

@section('content')
<!-- Hero -->
<div class="hero bg-body-extra-light overflow-hidden">
  <div class="hero-inner">
    <div class="content content-full text-center">
      <p class="mb-2">
        <i class="fas fa-fish fa-2x text-alert"></i>
      </p>

      <h1 class="fw-bold mb-2">
        ISPI v<span class="text-city">0.1a</span>
      </h1>
      <p class="fs-lg fw-medium text-muted mb-4">
        Parece que no estás logueado, ingresa tus credenciales para acceder.
      </p>
      <a class="btn btn-primary px-3 py-2" href="/login">
        Ingresar a tu cuenta
        <i class="fa fa-fw fa-arrow-right opacity-50 ms-1"></i>
      </a>
      <br><br>
      <p class="fs-lg fw-medium text-muted mb-4">
        ¿Nuevo en el sistema?
      </p>
      <a class="btn btn-danger px-3 py-2" href="/register">
        Registrar una nueva cuenta!
        <i class="fa fa-fw fa-arrow-right opacity-50 ms-1"></i>
      </a>
    </div>
    <!-- Example of a dark mode toggle button -->
    <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
      <i class="far fa-moon"></i>
    </a>

  </div>
</div>
<!-- END Hero -->
@endsection