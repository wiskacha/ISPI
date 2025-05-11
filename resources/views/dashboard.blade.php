@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Página de Inicio 
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Bienvenido
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <span>Bienvenida</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Contenido Principal -->
    <div class="content">
        <div class="row justify-content-center align-items-center min-vh-75">
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">¡Bienvenido!</h3>
                    </div>
                    <div class="block-content text-center py-5">
                        <h2 class="mb-4">¡Hola nuevamente!</h2>
                        <p class="fs-lg text-muted">
                            Tus herramientas de operación se encuentran en el panel izquierdo
                        </p>
                        <p class="fs-lg fw-semibold">
                            ¡Comienza a explorar todas las funcionalidades disponibles!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success') || isset($success))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="successToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Éxito</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    @if (session('success'))
                        {{ session('success') }}
                    @elseif (isset($success))
                        @if (is_array($success))
                            <ul>
                                @foreach ($success as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $success }}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif
    <!-- END Contenido Principal -->
@endsection
